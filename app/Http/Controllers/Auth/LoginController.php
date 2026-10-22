<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class LoginController
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function scockpit_auth(Request $request): RedirectResponse
    {

        if (! $request->has('code')) {
            return Socialite::with('s_cockpit')->redirect();
        }

        $scockpit_user = Socialite::with('s_cockpit')->user();

        $user = User::where('scockpit_user_id', '=', $scockpit_user->user['id'])->first();

        if (is_null($user)) {

            $user = User::create([
                'name' => $scockpit_user->user['full_name'],
                'first_name' => $scockpit_user->user['first_name'],
                'last_name' => $scockpit_user->user['last_name'],
                'email' => $scockpit_user->user['email'],
                'scockpit_user_id' => $scockpit_user->user['id'],
            ]);

        } else {

            $user->update([
                'name' => $scockpit_user->user['full_name'],
                'email' => $scockpit_user->user['email'],
            ]);

        }

        foreach ($scockpit_user->user['portals'] as $portal) {
            if ($portal['id'] == config('s_cockpit.portal-api.portal_id')) {
                $user->syncRoles($portal['roles']);
            }
        }

        \Auth::login($user);

        session()->put('user', $scockpit_user->user);

        return redirect()->to('/backend/dashboard');
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if (is_null($user->verified_at)) {
                return back()->withErrors([
                    'email' => 'Bitte warten sie, bis wir Ihr Benutzerkonto freigegeben haben.',
                ]);
            }

            return redirect()->intended('backend/dashboard');
        }

        return back()->withErrors([
            'email' => 'Die Anmeldeinformationen sind ungültig.',
        ]);

    }

    public function authenticated(Request $request, $user): RedirectResponse
    {

        if (is_null($user->verified_at)) {
            toastr()->error('Bitte warten Sie, bis Ihr Benutzerkonto von uns freigegeben wurde.');

            return redirect()->route('login')
                ->withErrors($request['email'])
                ->withInput();
        }

        $user->update([
            'lastlogon_at' => \Carbon\Carbon::now(),
        ]);

        return redirect()->to('/backend/dashboard');

    }
}
