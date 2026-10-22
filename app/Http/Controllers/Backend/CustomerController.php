<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Sorts\CustomerBudgetSort;
use App\Imports\CustomerImport;
use App\Models\Customer;
use App\Models\CustomerBudget;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerController extends Controller
{
    public function index (Request $request) {

        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch', 'filter.trashed'])
        );

        $customers = QueryBuilder::for(Customer::class, $filter)
            ->allowedFilters([
                'id', 'name', 'short_name', 'blz', 'bic', AllowedFilter::exact('association_id')
            ])
            ->allowedSorts([
                'id', 'name', 'blz', AllowedSort::custom('customBudget', new CustomerBudgetSort())
            ])->withTrashed();

        if (\request('filter.customSearch')) {
            $customers = $customers->customSearch(request('filter.customSearch'));
        }

        $customers = $customers->paginate(\request('per_page', 25));

        return view('backend.customers.overview', compact('customers'));
    }

    public function show (Request $request, Customer $customer, $tab = null) {

        /*
        * Check the Institute from Authenticated User and from Route
        */
        if (Auth::user()->customer->id !== $customer->id && Auth::user()->hasRole('Sparkasse')) {
            toastr()->error('Sie haben keinen Zugriff auf diese Sparkasse');

            return redirect()->route('backend.dashboard.index');
        }

        $customerContacts = $customer->contacts()->paginate(25);
        $customerUsers = $customer->users()->paginate(25);
        $measures = \App\Models\Measures::where('customer_ids', 'LIKE', '%"' . $customer->id . '"%')->orWhere('customer_ids', 'LIKE', '%"0"%')->paginate(25);

        $budgets = $customer->budgets()->orderBy('id', 'DESC')->where('budget_type', 'budget')->paginate(25);

        // Return to Tab after Pagination Change
        if (!empty($request['tab'])) {
            $tab = $request['tab'];
        }

        return view('backend.customers.show', compact('customer', 'tab', 'customerContacts', 'customerUsers', 'measures', 'budgets'));
    }

    public function edit (Request $request, Customer $customer) {

        /*
        * Check the Institute from Authenticated User and from Route
        */
        if (Auth::user()->customer->id !== $customer->id && Auth::user()->hasRole('Sparkasse')) {
            toastr()->error('Sie haben keinen Zugriff auf diese Sparkasse');

            return redirect()->route('backend.dashboard.index');
        }

        return view('backend.customers.edit', compact('customer'));
    }



    public function update (Request $request, Customer $customer) {

        $payload = $request->validate([
            'name' => 'required',
            'association_id' => 'required',
            'blz' => 'required',
            'bic' => 'required',
        ]);

        $payload['long_name'] = $payload['name'];

        $customer->update($payload);

        toastr()->success('Das Institut wurde erfolgreich gespeichert.');

        return redirect()->route('backend.customers.index', $customer);
    }

    public function delete (Request $request, Customer $customer) {

        $customer->budgets()->delete();

        $customer->contacts()->delete();

        $customer->measures()->delete();

        $customer->delete();

        toastr()->success('Das Institut wurde erfolgreich archiviert.');

        return redirect()->route('backend.customers.index');
    }

    public function updateContactPerson(Request $request, Customer $customer) {

        $payload = $request->validate([
            'internal_contact_persons' => 'nullable | array',
            'internal_contact_persons.*' => 'nullable | json',
        ]);

        foreach ($payload['internal_contact_persons'] as $key => $contact_person) {
            $payload['internal_contact_persons'][$key] = json_decode($contact_person, true);
        }

        $customer->update($payload);

        toastr()->success('Die Kontaktpersonen wurden erfolgreich geändert.');

        return redirect()->route('backend.customers.{customer}.show', $customer);
    }

    public function updateSocialNetwork (Request $request, Customer $customer) {

        $payload = $request->validate([
            'communcation_channels' => 'nullable|array',
            'customer_platforms' => 'nullable',
        ]);

        $customer->update($payload);

        toastr()->success('Die Daten wurden erfolgreich geändert.');

        return redirect()->route('backend.customers.{customer}.show', $customer);
    }

    public function showModal(Request $request)
    {
        $modal = 'show';

        $view = view('backend.customers.partials.modal.customer.showForm', compact('modal', 'request'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function showBalanceModal (Request $request) {
        $modal = 'show';

        $view = view('backend.customers.partials.modal.customer.showBalanceForm', compact('modal', 'request'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;
    }

    public function upload(Request $request)
    {

        $payload = $request->validate([
            'upload' => 'file|mimes:csv,txt,xlsx,xls',
        ]);

        Excel::import(new CustomerImport(), $request['upload']);

        toastr()->success('Der Import wurde erfolgreich ausgeführt.');


        return redirect()->route('backend.customers.index');

    }
}
