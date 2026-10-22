<?php

namespace App\Http\Controllers\Backend;

use App\Exports\AcquisitionExcelExport;
use App\Exports\ContactExcelExport;
use App\Exports\CustomerExcelExport;
use App\Exports\CustomerMeasureExcelExport;
use App\Exports\ProjectExcelExport;
use App\Exports\UserExcelExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\CustomerFilter;
use App\Http\Filters\CustomerProjectKeyAccountManagerFilter;
use App\Http\Filters\UserNameFilter;
use App\Http\Sorts\AcquisitionCustomerBlzSort;
use App\Http\Sorts\AcquisitionCustomerLocationSort;
use App\Http\Sorts\AcquisitionCustomerNameSort;
use App\Http\Sorts\ProjectCustomerBlzSort;
use App\Http\Sorts\ProjectCustomerNameSort;
use App\Imports\CustomerBalanceImport;
use App\Imports\ProjectsImport;
use App\Models\Customer;
use App\Models\CustomerAcquisition;
use App\Models\CustomerContact;
use App\Models\CustomerProject;
use App\Models\Measures;
use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ReportsController extends Controller
{
    public function importProjects(Request $request)
    {

        $payload = $request->validate([
            'formFile' => 'file|mimes:xlsx',
        ]);

        // File storage
        $filename = time().'_'.pathinfo(request()->file('formFile')->getClientOriginalName(), PATHINFO_FILENAME.'.'.PATHINFO_EXTENSION);
        $filepath = request()->file('formFile')->storeAs('uploads-tmp', $filename, 's3_public');

        // Import
        Excel::import(new ProjectsImport, request()->file('formFile'));

        toastr()->success('Der Import wurde erfolgreich durchgeführt.');

        return redirect()->route('backend.projects.index');
    }

    public function balance_customer(Request $request)
    {
        $payload = $request->validate([
            'file' => 'file|mimes:xlsx',
        ]);

        // Import
        Excel::import(new CustomerBalanceImport, request()->file('file'));

        // File storage
        $filename = time().'_'.pathinfo(request()->file('file')->getClientOriginalName(), PATHINFO_FILENAME.'.'.PATHINFO_EXTENSION);
        $filepath = request()->file('file')->storeAs('uploads-tmp', $filename, 's3_public');

        toastr()->success('Der Import wurde erfolgreich ausgeführt.');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.customers.index')])->setStatusCode(200);
    }

    public function excel_export_projects(Request $request)
    {
        return Excel::download(new ProjectExcelExport($this->getProjectFilterData($request)), 'Projects_Export-'.time().'.xlsx');
    }

    public function excel_export_acquisitions(Request $request)
    {
        return Excel::download(new AcquisitionExcelExport($this->getAcquisationFilterData($request)), 'Acquisitions_Export-'.time().'.xlsx');
    }

    public function excel_export_customers(Request $request)
    {
        return Excel::download(new CustomerExcelExport($this->getCustomerFilterData($request)), 'Customers_Export-'.time().'.xlsx');
    }

    public function excel_export_measure_customers(Measures $measure)
    {
        return Excel::download(new CustomerMeasureExcelExport($measure), 'Customers_Measure_Export-'.time().'.xlsx');
    }

    public function excel_export_contacts(Request $request)
    {
        return Excel::download(new ContactExcelExport($this->getContactFilterData($request)), 'Kontakt_Export-'.time().'.xlsx');
    }

    public function user_export_excel(Request $request)
    {
        return Excel::download(new UserExcelExport($this->getUserFilterData($request)), 'Personen_Export-'.time().'.xlsx');
    }

    public function getUserFilterData(Request $request)
    {
        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch', 'filter.trashed'])
        );

        $user = QueryBuilder::for(User::class, $filter)
            ->with(['customer'])->allowedFilters([
                'id', 'name', 'first_name', 'last_name', ' email', 'phone',
            ])
            ->allowedSorts([
                'id', 'last_name', 'first_name',
            ]);

        if (\request('filter.customSearch')) {
            $user = $user->customSearch(request('filter.customSearch'));
        }

        return $user->get();
    }

    // pdf_measure_export

    public function pdf_measure_export(Request $request)
    {

        $yearStart = Carbon::now()->startOfYear();
        $yearEnd = Carbon::now()->endOfYear();

        $measuresCurrentYear = Measures::where('customer_ids', 'LIKE', '%"'.Auth::user()->customer->id.'"%')->orWhere('customer_ids', 'LIKE', '%"0"%')->whereBetween('created_at', [$yearStart, $yearEnd])->get();

        $data = [
            'meta' => [
                'title' => 'Maßnahmen '.Carbon::now()->year,
                'date' => $request->input('date', date('d.m.Y')),
                'author' => $request->input('author', 'BCT Cockpit'),
            ],
            'measures' => $measuresCurrentYear,
        ];

        \PDF::setOptions([
            'dpi' => 300,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        $pdf = \PDF::loadView('reports/reports', $data)->setPaper('a4', 'landscape');

        return $pdf->download('Maßnahmen'.Carbon::now()->format('Y').'.pdf');
    }

    public function pdf_export_projects(Request $request)
    {
        $data = [
            'meta' => [
                'title' => $request->input('title', 'Institute'),
                'date' => $request->input('date', date('d.m.Y')),
                'author' => $request->input('author', 'S-Markt-Mehrwert Vertriebscockpit'),
                'watermark' => $request->input('watermark', null),
            ],
            'reports' => ['filtered_projects'],
            'projects' => $this->getProjectFilterData($request),
        ];

        \PDF::setOptions([
            'dpi' => 300,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        $pdf = \PDF::loadView('reports/reports', $data)->setPaper('a4', 'landscape');

        return $pdf->download('Vertriebsansaetze_'.Carbon::now()->format('d.m.Y').'.pdf');
    }

    public function pdf_export_customers(Request $request)
    {

        $data = [
            'meta' => [
                'title' => $request->input('title', 'Institute'),
                'date' => $request->input('date', date('d.m.Y')),
                'author' => $request->input('author', 'S-Markt-Mehrwert Vertriebscockpit'),
                'watermark' => $request->input('watermark', null),
            ],
            'reports' => ['filtered_customers'],
            'customers' => $this->getCustomerFilterData($request),
        ];

        \PDF::setOptions([
            'dpi' => 300,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        $pdf = \PDF::loadView('reports/reports', $data)->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function pdf_export_acquisitions(Request $request)
    {

        $data = [
            'meta' => [
                'title' => $request->input('title', 'Bericht'),
                'date' => $request->input('date', date('d.m.y')),
                'author' => $request->input('author', 'S-Markt-Mehrwert Vertriebscockpit'),
                'watermark' => $request->input('watermark', null),
            ],
            'reports' => ['filtered_acquisations'],
            'acquisations' => $this->getAcquisationFilterData($request),
        ];

        \PDF::setOptions([
            'dpi' => 300,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        $pdf = \PDF::loadView('reports/reports', $data)->setPaper('a4', 'landscape');

        return $pdf->stream();

    }

    public function getCustomerFilterData(Request $request)
    {
        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch', 'filter.trashed'])
        );

        $customers = QueryBuilder::for(Customer::class, $filter)
            ->allowedFilters([
                'id', 'name', 'long_name', 'blz', 'bic', 'mandant_id', 'association_id',
            ])
            ->allowedSorts([
                'id', 'name', 'location', 'classification_name', 'business_volume', 'key_account_manager', 'association_id',
            ]);

        if (\request('filter.customSearch')) {
            $customers = $customers->customSearch(request('filter.customSearch'));
        }

        return $customers->get();
    }

    public function getCustomerMeasureFilterData(Measures $measures)
    {

        dd($measures->customer_ids);
        if (in_array(0, $measure->customer_ids)) {
            $measure = \App\Models\Customer::all();
        } else {
            foreach ($measure->customer_ids as $customer_id) {

            }
        }
        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch', 'filter.trashed'])
        );

        $customers = QueryBuilder::for(Customer::class, $filter);

        return $customers->get();
    }

    public function getContactFilterData(Request $request)
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
            ]);

        if (\request('filter.customSearch')) {
            $customerContacts = $customerContacts->customSearch(request('filter.customSearch'));
        }

        return $customerContacts->get();
    }

    public function getAcquisationFilterData(Request $request)
    {
        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch', 'filter.trashed', 'filter.association', 'filter.product_services', 'filter.product_categories', 'filter.product_service_id'])
        );

        $filter_array = $filter->toArray();

        if (! is_null($request->input('filter.product_services')) && is_null($request->input('filter.product_categories'))) {

            $filtered_product_categorie = ProductCategories::where('product_service_id', request('filter.product_services'))->pluck('id')->toArray();
            $product_ids = Product::whereIn('category_id', $filtered_product_categorie)->pluck('id')->toArray();

            $filter_array['filter']['product_id'] = $product_ids;

        } elseif (! is_null($request->input('filter.product_services')) && ! is_null($request->input('filter.product_categories')) && is_null($request->input('filter.product_id'))) {

            $filtered_product_categorie = ProductCategories::where('id', request('filter.product_categories'))->pluck('id')->toArray();
            $product_ids = Product::whereIn('category_id', $filtered_product_categorie)->pluck('id')->toArray();

            $filter_array['filter']['product_id'] = $product_ids;
        }

        $filter->query->add($filter_array);

        $acquisitions = QueryBuilder::for(CustomerAcquisition::class, $filter)
            ->with(['customer'])->allowedFilters([
                'id', 'product_id', 'subject', 'user_id', 'done',
                AllowedFilter::exact('done'),
                AllowedFilter::exact('customer.association_id'),
                AllowedFilter::exact('customer.key_account_manager'),
                AllowedFilter::exact('product_id'),
            ])
            ->allowedSorts([
                AllowedSort::custom('name', new AcquisitionCustomerNameSort),
                AllowedSort::custom('product_id', new AcquisitionCustomerLocationSort),
                AllowedSort::custom('blz', new AcquisitionCustomerBlzSort),
                'id', 'subject', 'product_id', 'classification_name', 'business_volume', 'key_account_manager', 'association_id', 'done',
            ])
            ->get();

        return $acquisitions;
    }

    public function getProjectFilterData(Request $request)
    {
        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch', 'filter.trashed', 'filter.association', 'filter.product_services', 'filter.product_categories'])
        );

        $filter_array = $filter->toArray();

        if (! is_null($request->input('filter.product_services')) && is_null($request->input('filter.product_categories'))) {
            $filtered_product_categorie = ProductCategories::where('product_service_id', request('filter.product_services'))->pluck('id')->toArray();
            $product_ids = Product::whereIn('category_id', $filtered_product_categorie)->pluck('id')->toArray();
            $filter_array['filter']['product_id'] = $product_ids;

        } elseif (! is_null($request->input('filter.product_services')) && ! is_null($request->input('filter.product_categories')) && is_null($request->input('filter.product_id'))) {

            $filtered_product_categorie = ProductCategories::where('id', request('filter.product_categories'))->pluck('id')->toArray();
            $product_ids = Product::whereIn('category_id', $filtered_product_categorie)->pluck('id')->toArray();

            $filter_array['filter']['product_id'] = $product_ids;
        }

        $filter->query->add($filter_array);

        $customerProjects = QueryBuilder::for(CustomerProject::class, $filter)
            ->with(['customer'])->allowedFilters([
                'id',  'name', 'short_name', 'blz', 'bic', 'location', 'approved_appointment', 'business_data', 'is_customer', 'product_id', 'status',
                AllowedFilter::exact('type_id'),
                AllowedFilter::exact('classification_id'),
                AllowedFilter::exact('customer.association_id'),
                AllowedFilter::custom('vertrieb_mehrwerte_beratung', new CustomerProjectKeyAccountManagerFilter),
                AllowedFilter::scope('introduction_on'),
                AllowedFilter::scope('filter_done_from'),
                AllowedFilter::scope('done_from'),
                AllowedFilter::exact('project_delivery_note_send'),
                AllowedFilter::exact('project_delivery_note_back'),
            ])
            ->allowedSorts([
                'status', 'introduction_on', AllowedSort::custom('name', new ProjectCustomerNameSort), AllowedSort::custom('blz', new ProjectCustomerBlzSort),
            ])->get();

        return $customerProjects;
    }
}
