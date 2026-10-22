<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Filters\CustomerProjectKeyAccountManagerFilter;
use App\Http\Sorts\ProjectCustomerBlzSort;
use App\Http\Sorts\ProjectCustomerNameSort;
use App\Models\Customer;
use App\Models\CustomerProject;
use App\Models\File;
use App\Models\Product;
use App\Models\ProductCategories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerProjectController extends Controller
{
    public function index(Request $request): View
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
                'status', 'introduction_on', 'done_from', AllowedSort::custom('name', new ProjectCustomerNameSort), AllowedSort::custom('blz', new ProjectCustomerBlzSort),
            ])->paginate(\request('per_page', 25));

        $customerProjectsChart = QueryBuilder::for(CustomerProject::class, $filter)
            ->with(['customer'])->allowedFilters([
                'id', 'name', 'short_name', 'blz', 'bic', 'location', 'business_data', 'approved_appointment',  'is_customer', 'product_id', 'status', 'introduction_on', 'done_from',
                AllowedFilter::exact('type_id'),
                AllowedFilter::exact('classification_id'),
                AllowedFilter::exact('customer.association_id'),
                AllowedFilter::custom('vertrieb_mehrwerte_beratung', new CustomerProjectKeyAccountManagerFilter),
                AllowedFilter::exact('customer_id'),
                AllowedFilter::exact('project_delivery_note_send'),
                AllowedFilter::exact('project_delivery_note_back'),
            ])
            ->allowedSorts([
                'status', 'introduction_on', 'done_from', AllowedSort::custom('name', new ProjectCustomerNameSort), AllowedSort::custom('blz', new ProjectCustomerBlzSort),
            ])->get();

        $pieChartData['data'] = $customerProjectsChart->groupBy('status');
        $pieChartData['data'] = collect([
            'Interesse bekundet' => is_null($pieChartData['data']['Interesse']) ? 0 : $pieChartData['data']['Interesse'],
            'Angebot übergeben' => is_null($pieChartData['data']['Angebot übergeben']) ? 0 : $pieChartData['data']['Angebot übergeben'],
            'Auftrag avisiert' => is_null($pieChartData['data']['Auftrag avisiert']) ? 0 : $pieChartData['data']['Auftrag avisiert'],
            'Auftrag erteilt' => is_null($pieChartData['data']['Auftrag erteilt']) ? 0 : $pieChartData['data']['Auftrag erteilt'],
            'Vertriebsansatz abgeschlossen' => is_null($pieChartData['data']['Vertriebsansatz abgeschlossen']) ? 0 : $pieChartData['data']['Vertriebsansatz abgeschlossen'],
            'Umsetzung verschoben' => is_null($pieChartData['data']['Umsetzung verschoben']) ? 0 : $pieChartData['data']['Umsetzung verschoben'],
            'Vorläufig abgelehnt' => is_null($pieChartData['data']['Vorläufig abgelehnt']) ? 0 : $pieChartData['data']['Vorläufig abgelehnt'],
            'Angebot abgelehnt' => is_null($pieChartData['data']['Angebot abgelehnt']) ? 0 : $pieChartData['data']['Angebot abgelehnt'],
        ]);

        $pieChartData['total'] = $customerProjectsChart->count();

        $listCountStatus = [];
        $wholeCount = 0;

        $statusList = [
            'Interesse' => 0,
            'Vorläufig abgelehnt' => 0,
            'Angebot übergeben' => 0,
            'Auftrag avisiert' => 0,
            'Auftrag erteilt' => 0,
            'Vertriebsansatz abgeschlossen' => 0,
            'Umsetzung verschoben' => 0,
            'Angebot abgelehnt' => 0,
        ];

        $collection = collect($customerProjectsChart);

        // Prefill timeline (0 => not-approved, 1 => approved)
        $timeline = [
            0 => [],
            1 => [],
        ];
        $total = [
            0 => 0,
            1 => 0,
        ];

        // Set up timeline (now -3 months and plus 15 months)
        $from = Carbon::now()->subMonth(3);
        $to = Carbon::now()->addMonth(15);
        $now = $from;
        $timeline_header = [];
        while ($now < $to) {
            $monthYear = $this->convert_to_german_month($now, $now->format('y'));
            // $monthYear = $now->format('M');
            $timeline[0][$now->format('Y-m')] = 0;
            $timeline[1][$now->format('Y-m')] = 0;
            $timeline_header[$now->format('Y-m')] = $monthYear;

            $now->addMonth(1);
        }

        foreach ($collection as $element) {
            if (array_key_exists($element['status'], $statusList)) {
                $statusList[$element['status']] = $statusList[$element['status']] + 1;
                $wholeCount = $wholeCount + 1;
            }

            $introduction_date = substr($element['introduction_on'], 0, 7);

            if ($element['introduction_on'] !== null) {

                if (array_key_exists($introduction_date, $timeline[0])) {

                    $timeline[$element['approved_appointment']][$introduction_date] += 1;
                    $total[$element['approved_appointment']] += 1;

                }

            }
        }

        $listCountStatus = array_merge($listCountStatus, $statusList);
        $listCountStatus = array_merge($listCountStatus, ['total' => $wholeCount]);

        $chart['timeline'] = [
            'header' => $timeline_header,
            'data' => $timeline,
            'total' => $total,
        ];

        return view('backend.projects.overview', compact('customerProjects', 'pieChartData', 'chart'));
    }

    public function create(Request $request, Customer $customer, CustomerProject $project)
    {
        $modal = 'create';

        $view = view('backend.customers.partials.modal.project.createUpdateForm', compact('modal', 'project', 'customer'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function store(Request $request, Customer $customer): JsonResponse
    {

        $data = Validator::make($request->all(), [
            'project_created_by' => 'required',
            'created_at' => 'required|date',
            'subject' => 'required|max:255',
            'product_id' => 'required',
            'product_categorie' => 'required',
            'status' => 'required|max:255',
            'done_chance' => 'required',
            // 'planned_appointment' => 'required',
            'introduction_on' => 'nullable|date',
            'done_from' => 'nullable|date',
            // 'done_until' => 'nullable',
            'approved_appointment' => 'nullable',
            'send_project' => 'nullable',
            'send_at' => 'nullable',
            'marktfolge_user' => 'nullable',
            'additional_marktfolge' => 'nullable',
            'customer_id' => 'required',
            'salesPerYear' => 'nullable',
            'notes' => 'nullable',
            'dateRadioButton' => 'nullable',
            'lead_dsv' => 'nullable|boolean',
            'project_delivery_note_send' => 'nullable|boolean',
            'project_delivery_note_send_date' => 'nullable|date',
            'project_delivery_note_back' => 'nullable|boolean',
            'project_delivery_note_back_date' => 'nullable|date',
            'contact_history' => 'nullable',
            'contact_person' => 'required',
            'first_contact_date' => 'nullable|date',
            'next_contact_date' => 'nullable|date',
            'file' => 'nullable',
        ]);

        if ($data->fails()) {
            return response()->json(['status' => 'error', 'errors' => $data->errors()])->setStatusCode(200);
        } else {
            $payload = $data->valid();
        }

        $project = CustomerProject::create($payload);

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $fileName = hash('sha512', time().$request->get('name').$request->file->getClientOriginalName());
            $path = $request->file->storeAs('files', $fileName, 's3_local');

            File::create([
                'name' => $fileName,
                'description' => $file->getClientOriginalName(),
                'checksum' => md5_file(storage_path('app/'.$path)),
                'fileable_type' => 'project',
                'fileable_id' => $project->id,
            ]);
        }

        toastr()->success('Der Vertriebsansatz wurde erfolgreich angelegt.');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.customers.{customer}.modalTabs', [$customer, 'projects'])])->setStatusCode(200);

    }

    public function showExportModal(Request $request)
    {

        $modal = 'show';

        $view = view('backend.customers.partials.modal.project.showFormPDFExport', compact('modal', 'request'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function show(Request $request, Customer $customer, CustomerProject $project)
    {
        $modal = 'show';

        $view = view('backend.customers.partials.modal.project.showForm', compact('modal', 'project', 'customer'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function edit(Request $request, Customer $customer, CustomerProject $project)
    {
        $modal = 'update';

        $view = view('backend.customers.partials.modal.project.createUpdateForm', compact('modal', 'project', 'customer'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function update(Request $request, Customer $customer, CustomerProject $project): JsonResponse
    {

        $data = Validator::make($request->all(), [
            'project_created_by' => 'required',
            'created_at' => 'required|date',
            'subject' => 'required|max:255',
            'product_id' => 'required',
            'product_categorie' => 'required',
            'status' => 'required|max:255',
            'done_chance' => 'required',
            // 'planned_appointment' => 'required',
            'introduction_on' => 'nullable|date',
            'done_from' => 'nullable|date',
            // 'done_until' => 'nullable',
            'approved_appointment' => 'nullable',
            'send_project' => 'nullable',
            'send_at' => 'nullable',
            'marktfolge_user' => 'nullable',
            'additional_marktfolge' => 'nullable',
            'customer_id' => 'required',
            'salesPerYear' => 'nullable',
            'notes' => 'nullable',
            'dateRadioButton' => 'nullable',
            'lead_dsv' => 'nullable|boolean',
            'project_delivery_note_send' => 'nullable|boolean',
            'project_delivery_note_send_date' => 'nullable|date',
            'project_delivery_note_back' => 'nullable|boolean',
            'project_delivery_note_back_date' => 'nullable|date',
            'contact_history' => 'nullable',
            'contact_person' => 'required',
            'first_contact_date' => 'nullable|date',
            'next_contact_date' => 'nullable|date',
            'file' => 'nullable',
        ]);

        if ($data->fails()) {
            return response()->json(['status' => 'error', 'errors' => $data->errors()])->setStatusCode(200);
        } else {
            $payload = $data->valid();
        }

        $project->update($payload);

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $fileName = hash('sha512', time().$request->get('name').$request->file->getClientOriginalName());
            $path = $request->file->storeAs('files', $fileName, 's3_local');

            File::create([
                'name' => $fileName,
                'description' => $file->getClientOriginalName(),
                'checksum' => md5_file(storage_path('app/'.$path)),
                'fileable_type' => 'project',
                'fileable_id' => $project->id,
            ]);
        }

        toastr()->success('Der Vertriebsansatz wurde erfolgreich gespeichert.');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.customers.{customer}.modalTabs', [$customer, 'projects'])])->setStatusCode(200);

    }

    public function convert_to_german_month(\Carbon\Carbon $date, string $year): string
    {
        $month_mapping = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mär',
            4 => 'Apr',
            5 => 'Mai',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Dez',
        ];
        if (array_key_exists($date->format('n'), $month_mapping)) {
            $month_year = $month_mapping[$date->format('n')].' '.$year;
        } else {
            $month_year = $date->format('M').' '.$year;
        }

        return $month_year;
    }

    public function product_categories($id): JsonResponse
    {

        $categories = ProductCategories::where('product_service_id', $id)->get();

        return response()->json($categories);
    }

    public function product(Request $request): JsonResponse
    {

        $data = $request->all();

        $products = Product::whereIn('category_id', $data['data'])->get();

        return response()->json($products);
    }

    public function destroy(Request $request, $project): JsonResponse
    {
        $project = CustomerProject::find($project);
        $project->delete();

        toastr()->success('Der Vertriebsansatz wurde erfolgreich gelöscht.');

        return response()->json([
            'success' => true,
        ]);
    }

    public function tabFilterIndex(Request $request, Customer $customer): View
    {

        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch', 'filter.trashed', 'filter.association', 'filter.product_services', 'filter.product_categories'])
        );

        $customerProjects = QueryBuilder::for(CustomerProject::class, $filter)
            ->with(['customer'])->allowedFilters([
                'id',  'name', 'short_name', 'blz', 'bic', 'location', 'approved_appointment', 'business_data', 'is_customer', 'product_id', 'status', 'done_from',
                AllowedFilter::exact('status'),
                AllowedFilter::scope('introduction_on'),
                AllowedFilter::scope('done_from'),
            ])
            ->where('customer_id', $customer->id)
            ->allowedSorts([
                'status', 'introduction_on', 'done_from',
            ])->paginate(\request('per_page', 25));

        $tab = 'projects';
        $showFilter = true;

        return view('backend.customers.show', compact('customer', 'customerProjects', 'tab', 'showFilter'));

    }
}
