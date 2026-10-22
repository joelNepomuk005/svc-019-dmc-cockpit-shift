<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\CustomerMeasures;
use App\Models\Measures;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $perPage = request('per_page', 5);

        $customersQuery = QueryBuilder::for(Customer::class, $request)
            ->allowedFilters(['id', 'name', 'short_name', 'blz', 'bic'])
            ->allowedSorts([
                'id', 'name',
            ]);

        $rolesQuery = QueryBuilder::for(Role::class, $request)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts([
                'id', 'name',
            ]);

        //        $customerMeasuresQuery = QueryBuilder::for(CustomerMeasures::class, $request)
        //            ->allowedFilters(['id', 'name',])
        //            ->allowedSorts([
        //                'id', 'name',
        //            ]);

        $measuresQuery = QueryBuilder::for(Measures::class, $request)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts([
                'id', 'name',
            ]);

        $customerContactsQuery = QueryBuilder::for(CustomerContact::class, $request)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts([
                'id', 'name',
            ]);

        if (Auth::user()->hasRole('Sparkasse')) {
            $customersQuery->where('id', Auth::user()->customer->id);
            // $customerMeasuresQuery->where('customer_id', Auth::user()->customer->id);
            $measuresQuery->where('customer_ids', 'LIKE', '%"'.Auth::user()->customer->id.'"%')->orWhere('customer_ids', 'LIKE', '%"0"%');

            $customerContactsQuery->where('customer_id', Auth::user()->customer->id);
        }

        $perPage = 10;
        $customers = $customersQuery->paginate($perPage, ['*'], 'customers');
        $roles = $rolesQuery->paginate($perPage, ['*'], 'roles');
        $measures = $measuresQuery->paginate($perPage, ['*'], 'measures');
        $customerContacts = $customerContactsQuery->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'customerContacts');

        $chartData = [];
        $chartData['active_measures'] = 0;
        $chartData['negative_measures'] = 0;

        if (Auth::user()->hasRole('Sparkasse')) {
            $customer = Customer::find(Auth::user()->customer_id);
            $measureAmount = Measures::where('customer_ids', 'LIKE', '%"'.Auth::user()->customer->id.'"%')->orWhere('customer_ids', 'LIKE', '%"0"%')->get()->count();

            $chartData['positive_budget'] += $customer->sumPositiveBudgets();
            $chartData['negative_budget'] += str_replace('-', '', $customer->sumNegativeBudgets());

            $chartData['positive_budget_diagram'] += $customer->sumPositiveBudgetsDiagramm();
            $chartData['negative_budget_diagram'] += $customer->sumNegativeBudgetsDiagramm();

            if ($measureAmount > 0) {
                $chartData['active_measures'] += $measureAmount;
            } else {
                $chartData['inactive_measures'] += $measureAmount;
            }

        } else {
            foreach (Customer::all() as $customer) {

                $measureAmount = Measures::where('customer_ids', 'LIKE', '%"'.Auth::user()->customer->id.'"%')->orWhere('customer_ids', 'LIKE', '%"0"%')->get()->count();

                $chartData['positive_budget'] += $customer->sumPositiveBudgets();
                $chartData['negative_budget'] += str_replace('-', '', $customer->sumNegativeBudgets());

                $chartData['positive_budget_diagram'] += $customer->sumPositiveBudgetsDiagramm();
                $chartData['negative_budget_diagram'] += $customer->sumNegativeBudgetsDiagramm();

                if ($measureAmount > 0) {
                    $chartData['active_measures'] += $measureAmount;
                } else {
                    $chartData['inactive_measures'] += $measureAmount;
                }
            }
        }
        $chartData['customer_measures'] = CustomerMeasures::all()->groupBy('customer_id')->count();

        return view('backend.dashboard.show', compact('customers', 'measures', 'roles', 'customerContacts', 'chartData'));
    }

    public function getContacts(Request $request): JsonResponse
    {

        $perPage = $request->numberOfItems;

        $customerContactsQuery = QueryBuilder::for(CustomerContact::class, $request)
            ->allowedFilters(['id', 'name'])
            ->with(['customer', 'user'])
            ->allowedSorts([
                'id', 'name',
            ]);

        if (Auth::user()->hasRole('Sparkasse')) {
            $customerContactsQuery->where('customer_id', Auth::user()->customer->id);
        }

        $customerContacts = $customerContactsQuery->paginate($perPage, ['*'], 'customerContacts');

        return response()->json($customerContacts);
    }

    public function getMeasures(Request $request): JsonResponse
    {

        $perPage = $request->numberOfItems;

        $customerMeasuresQuery = QueryBuilder::for(CustomerMeasures::class, $request)
            ->allowedFilters(['id', 'name'])
            ->with(['customer', 'measure'])
            ->allowedSorts([
                'id', 'name',
            ]);

        if (Auth::user()->hasRole('Sparkasse')) {
            $customerMeasuresQuery->where('customer_id', Auth::user()->customer->id);
        }

        $customerMeasures = $customerMeasuresQuery->paginate($perPage, ['*'], 'customerMeasures');

        return response()->json($customerMeasures);
    }

    public function show(Request $request)
    {
        $modal = 'show';

        $view = view('backend.dashboard.modal.contact.showForm')->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }
}
