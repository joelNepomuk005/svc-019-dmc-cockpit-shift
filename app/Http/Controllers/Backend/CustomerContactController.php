<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Filters\CustomerFilter;
use App\Http\Filters\UserNameFilter;
use App\Models\Customer;
use App\Models\CustomerContact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerContactController extends Controller
{
    public function index(Request $request): View
    {
        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch', 'filter.trashed'])
        );

        $customerContacts = QueryBuilder::for(CustomerContact::class, $filter)
            ->allowedFilters([
                'id', 'title', 'date',
                AllowedFilter::custom('customer', new CustomerFilter),
                AllowedFilter::custom('name', new UserNameFilter),
                AllowedFilter::scope('date'),
            ])
            ->allowedSorts([
                'id', 'title', 'date', 'created_at',
            ])
            ->orderBy('created_at', 'desc');

        if (\request('filter.customSearch')) {
            $customerContacts = $customerContacts->customSearch(request('filter.customSearch'));
        }

        $customerContacts = $customerContacts->paginate(\request('per_page', 25));

        return view('backend.contacts.overview', compact('customerContacts'));
    }

    public function create(Request $request, CustomerContact $contact, Customer $customer)
    {
        $modal = 'create';

        $view = view('backend.customers.partials.modal.contact.createUpdateForm', compact('modal', 'contact', 'customer'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function show(Request $request, CustomerContact $customerContact)
    {
        $modal = 'show';

        $view = view('backend.customers.partials.modal.contact.showForm', compact('modal', 'customerContact'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function store(Request $request, Customer $customer): JsonResponse
    {
        $payload = $request->validate([
            'date' => 'required|date',
            'title' => 'required',
            'contact_type_id' => 'required',
            'user_id' => 'required|exists:users,id',
            'contact_person_id' => 'required|exists:users,id',
        ]);

        $payload['customer_id'] = $customer->id;
        $payload['user_id_log'] = Auth::user()->id;
        $payload['contact_type_id'] = intval($payload['contact_type_id']);

        CustomerContact::create($payload);

        toastr()->success('Der Kontakt wurde erfolgreich angelegt.');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.customers.{customer}.modalTabs', [$customer, 'contacts'])])->setStatusCode(200);

    }

    public function update(Request $request, Customer $customer, CustomerContact $customerContact): JsonResponse
    {
        $payload = $request->validate([
            'date' => 'required|date',
            'title' => 'required',
            // 'user_id' => 'required|exists:users,id',
        ]);

        $payload['customer_id'] = $customer->id;
        $payload['user_id_log'] = Auth::user()->id;

        $customerContact->update($payload);

        toastr()->success('Der Kontakt wurde erfolgreich bearbeitet.');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.customers.{customer}.modalTabs', [$customer, 'contacts'])])->setStatusCode(200);

    }

    public function edit(Request $request, Customer $customer, CustomerContact $customerContact)
    {
        $modal = 'update';

        $view = view('backend.customers.partials.modal.contact.createUpdateForm', compact('modal', 'customerContact', 'customer'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function destroy(Request $request, Customer $customer, CustomerContact $customerContact): JsonResponse
    {
        $customerContact->delete();

        toastr()->success('Der Kontakt wurde erfolgreich gelöscht.');

        return response()->json([
            'success' => true,
        ]);
    }
}
