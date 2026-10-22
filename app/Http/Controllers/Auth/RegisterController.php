<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Mail\sendmailNewRegistration;
use App\Models\Customer;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function check_blz(Request $request): View
    {
        return view('auth.register.index');

    }

    public function verification_success(Request $request): View
    {

        return view('auth.register.verification_success');

    }

    public function reset_password_success(Request $request): View
    {

        return view('auth.register.reset_password_success');

    }

    public function verification(Request $request): View
    {

        return view('auth.register.verification_email');

    }

    public function verification_failed(Request $request): View
    {

        return view('auth.register.create', ['blz' => $request['blz']]);

    }

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {

        return Validator::make($data, [
            'sex' => ['required', 'string', 'max:6'],
            'name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function verify_blz(Request $request)
    {
        $payload = $request->validate([
            'blz' => 'required',
        ]);

        $customer = Customer::where('blz', $payload['blz'])->exists();

        if ($customer) {
            return view('auth.register.create', ['blz' => $payload['blz']]);
        } else {
            toastr()->error('Die angegebene BLZ konnte nicht zugeordnet werden.');

            return redirect()->route('check_blz');
        }

    }

    protected function create(array $data)
    {

        $customer_id = Customer::where('blz', $data['blz'])->value('id');

        $user = User::create([
            'name' => $data['name'],
            'sex' => $data['sex'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'is_new' => $data['is_new'],
            'customer_id' => $customer_id,
            'job_title' => $data['job_title'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('Sparkasse');

        return $user;

    }

    public function register_user(Request $request): RedirectResponse
    {

        $request['name'] = $request['first_name'].' '.$request['last_name'];
        $validator = $this->validator($request->all());

        if ($validator->fails()) {

            return redirect()->route('verification_failed', ['blz' => $request['blz']])
                ->withErrors($validator)
                ->withInput();

        } else {

            $checkIfEmailExists = User::where('email', $request['email'])->exists();

            if ($checkIfEmailExists) {

                toastr()->error('Die angegebene E-Mailadresse wurde bereist registriert.');

                return redirect()->route('verification_failed', ['blz' => $request['blz']])
                    ->withErrors($validator)
                    ->withInput();

            } else {
                $this->create($request->all());
                $this->sendConfirmationEmail();

                return redirect()->route('verification');
            }

        }

    }

    public function sendConfirmationEmail()
    {

        try {
            $content = 'Eine neue Registrierung von einem SK-Mitarbeiter ist vorhanden';
            if (env('APP_ENV') === 'local' || env('APP_ENV') === 'development') {
                Mail::to(['development@digitalbynature.de'])
                    ->send(new sendmailNewRegistration('Neuregistrierung', $content));
            } else {
                Mail::to(['marcel.weber@s-imk.de', 'dmc@s-markt-mehrwert.de'])
                    ->send(new sendmailNewRegistration('Neuregistrierung', $content));
            }
        } catch (\Exception $exception) {
            Log::error($exception);
        }

    }
}
