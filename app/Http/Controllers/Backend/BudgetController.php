<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index(Request $request) {}

    public function createCustomer(Request $request, CustomerBudget $budget, Customer $customer, $type)
    {
        $modal = 'create';

        $view = view('backend.customers.partials.modal.budget.createUpdateForm', compact('modal', 'budget', 'customer', 'type'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function show(Request $request, Customer $customer, CustomerBudget $budget)
    {
        $modal = 'show';

        $view = view('backend.customers.partials.modal.budget.showForm', compact('modal', 'budget'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function storeCustomer(Request $request, Customer $customer, $type)
    {
        $payload = $request->validate([
            'amount' => 'required',
            'note' => 'required',
            'measure_id' => 'nullable',
        ]);

        $payload['user_id'] = Auth::user()->id;
        $payload['customer_id'] = $customer->id;
        $payload['budget_type'] = $type;

        $customerBudget = CustomerBudget::create($payload);

        activity()
            ->performedOn($customerBudget)
            ->causedBy(Auth::user());

        toastr()->success('Das Budget wurde erfolgreich angelegt.');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.customers.{customer}.modalTabs', [$customer, 'budgets'])])->setStatusCode(200);

    }

    public function updateCustomer(Request $request, Customer $customer, CustomerBudget $budget, $type)
    {
        $payload = $request->validate([
            'amount' => 'required',
            'note' => 'required',
            'measure_id' => 'nullable',
        ]);

        $payload['user_id'] = Auth::user()->id;
        $payload['customer_id'] = $customer->id;
        $payload['budget_type'] = $type;

        $budget->update($payload);

        activity()
            ->performedOn($budget)
            ->causedBy(Auth::user());

        toastr()->success('Das Budget wurde erfolgreich bearbeitet.');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.customers.{customer}.modalTabs', [$customer, 'budgets'])])->setStatusCode(200);

    }

    public function editCustomer(Request $request, Customer $customer, CustomerBudget $budget, $type)
    {
        $modal = 'update';

        $view = view('backend.customers.partials.modal.budget.createUpdateForm', compact('modal', 'budget', 'customer', 'type'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function destroy(Request $request, Customer $customer, CustomerBudget $budget)
    {
        $budget->delete();

        toastr()->success('Das Budget wurde erfolgreich gelöscht.');

        return response()->json([
            'success' => true,
        ]);
    }
}
