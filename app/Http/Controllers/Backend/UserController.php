<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Filters\UserScockpitFilter;
use App\Mail\sendmail;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.trashed'])
        );

        $usersQuery = QueryBuilder::for(User::class, $filter)
            ->allowedFilters([
                'id', 'name', 'first_name', 'last_name', ' email', 'phone',
                AllowedFilter::scope('customSearch'),
                AllowedFilter::custom('scockpit_user_id', new UserScockpitFilter),
            ])
            ->defaultSort('-id')
            ->allowedSorts([
                'id', 'last_name', 'first_name',
            ]);

        if (Auth::user()->hasRole('Sparkasse')) {
            $usersQuery->where('customer_id', Auth::user()->customer_id);
        }

        $users = $usersQuery->paginate(\request('per_page', 25));

        return view('backend.users.overview', compact('users'));
    }

    public function show(User $user)
    {
        $modal = 'show';

        $view = view('backend.users.partials.showForm', compact('modal', 'user'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;
    }

    public function create(User $user)
    {
        $modal = 'create';

        $view = view('backend.users.partials.createUpdateForm', compact('modal', 'user'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;
    }

    public function createCustomer(User $user, Customer $customer)
    {
        $modal = 'create';

        $view = view('backend.customers.partials.modal.user.createUpdateForm', compact('modal', 'user', 'customer'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;
    }

    public function store(Request $request): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'salutation' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable|max:20',
            'customer_id' => 'required',
            'categorie_id' => 'nullable',
        ]);

        if ($data->fails()) {
            return response()->json(['status' => 'error', 'errors' => $data->errors()])->setStatusCode(200);
        } else {
            $payload = $data->valid();
        }

        $payload['name'] = $payload['first_name'].' '.$payload['last_name'];

        $user = User::create($payload);
        $user->assignRole('Sparkasse');

        toastr()->success('Der Berater wurde erfolgreich angelegt.');

        return response()->json(['status' => 'success', 'type' => 'reload'])->setStatusCode(200);
    }

    public function storeCustomer(Request $request, Customer $customer): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'salutation' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable|max:20',
            'categorie_id' => 'nullable',
        ]);

        if ($data->fails()) {
            return response()->json(['status' => 'error', 'errors' => $data->errors()])->setStatusCode(200);
        } else {
            $payload = $data->valid();
        }

        $payload['name'] = $payload['first_name'].' '.$payload['last_name'];
        $payload['customer_id'] = $customer->id;

        User::create($payload);

        toastr()->success('Der Berater wurde erfolgreich angelegt.');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.customers.{customer}.modalTabs', [$customer, 'users'])])->setStatusCode(200);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'salutation' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable|max:20',
            'customer_id' => 'required',
            'categorie_id' => 'nullable',
        ]);

        if ($data->fails()) {
            return response()->json(['status' => 'error', 'errors' => $data->errors()])->setStatusCode(200);
        } else {
            $payload = $data->valid();
        }

        $payload['name'] = $payload['first_name'].' '.$payload['last_name'];

        $user->update($payload);

        toastr()->success('Der Berater wurde erfolgreich angelegt.');

        return response()->json(['status' => 'success', 'type' => 'reload'])->setStatusCode(200);
    }

    public function updateCustomer(Request $request, Customer $customer, User $user): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'salutation' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable|max:20',
            'categorie_id' => 'nullable',
            'customer_id' => 'nullable',
        ]);

        if ($data->fails()) {
            return response()->json(['status' => 'error', 'errors' => $data->errors()])->setStatusCode(200);
        } else {
            $payload = $data->valid();
        }

        $payload['name'] = $payload['first_name'].' '.$payload['last_name'];

        $user->update($payload);

        toastr()->success('Der Berater wurde erfolgreich angelegt.');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.customers.{customer}.modalTabs', [$customer, 'users'])])->setStatusCode(200);
    }

    public function edit(Request $request, User $user, Customer $customer)
    {
        $modal = 'update';

        $view = view('backend.users.partials.createUpdateForm', compact('modal', 'user'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;
    }

    public function editCustomer(Request $request, Customer $customer, User $user)
    {
        $modal = 'update';

        $view = view('backend.customers.partials.modal.user.createUpdateForm', compact('modal', 'user', 'customer'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;
    }

    public function release(Request $request, User $user): RedirectResponse
    {

        $user->verified_at = Carbon::now();
        $user->save();

        try {

            $content = 'Ihr Benutzerkonto für das DMC-Cockpit wurde erfolgreich freigegeben.';
            Mail::to(env('APP_ENV') != 'production' ? 'development@digitalbynature.de' : $user->email)->send(new sendmail('Freischaltung Ihres DMC-Cockpit Zugangs', $content, $user));
            toastr()->success('Der Berater wurde erfolgreich freigegeben.');

        } catch (\Exception $exception) {
            Log::error($exception);
            toastr()->error('Die E-Mail Benachrichtigung konnte nicht versendet werden.');
        }

        return redirect()->to('/backend/users');
    }

    public function destroy(Request $request, User $user): JsonResponse
    {
        if (empty($user->scockpit_user_id)) {
            $user->delete();

            activity()
                ->causedBy(Auth::user())
                ->performedOn($user);

            toastr()->success('Die Person wurde erfolgreich gelöscht.');

            return response()->json([
                'success' => true,
            ]);
        } else {
            toastr()->error('Diese Person kann nicht gelöscht werden, da Sie einen Benutzeraccount hat.');

            return response()->json([
                'success' => false,
                'data' => 'Diese Person kann nicht gelöscht werden, da Sie einen Benutzeraccount hat.',
            ]);
        }
    }

    public function impersonate(User $user): RedirectResponse
    {
        auth()->user()->impersonate($user);

        session(['impersonate_return' => route('backend.dashboard.index')]);

        return redirect()->route('backend.dashboard.index');
    }

    public function leaveImpersonate(User $user): RedirectResponse
    {
        auth()->user()->leaveImpersonation();

        return redirect()->route('backend.dashboard.index');
    }
}
