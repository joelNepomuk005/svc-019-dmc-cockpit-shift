<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Variables;
use App\Http\Controllers\Controller;
use App\Http\Filters\CustomerStateFilter;
use App\Models\Customer;
use App\Models\CustomerMeasures;
use App\Models\File;
use App\Models\Measures;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MeasuresController extends Controller
{
    public function index(Request $request)
    {

        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch'])
        );

        $measures = QueryBuilder::for(Measures::class, $filter)
            ->allowedFilters([
                'id', 'name',
            ])
            ->allowedSorts([
                'id', 'name',
            ])
            ->defaultSort('-id')
            ->paginate(\request('per_page', 25));

        $activeMeasures = 0;
        $inactiveMeasures = 0;

        foreach (Customer::all() as $customer) {
            $customerMeasure = CustomerMeasures::where('customer_id', $customer->id)->get()->count();
            if ($customerMeasure > 0) {
                $activeMeasures++;
            } else {
                $inactiveMeasures++;
            }
        }

        return view('backend.measures.overview', compact('measures', 'activeMeasures', 'inactiveMeasures'));
    }

    public function show(Request $request, Measures $measure)
    {

        return view('backend.measures.show', compact('measure'));
    }

    public function showModal(Request $request, Measures $measure)
    {
        $modal = 'show';

        $view = view('backend.measures.partials.showForm', compact('modal', 'measure', 'customers'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function showModalCustomer(Request $request, Customer $customer, Measures $measure)
    {
        $modal = 'show';

        $customerMeasure = $measure->customerMeasure($customer->id);

        $view = view('backend.customers.partials.modal.measure.showForm', compact('modal', 'customer', 'measure', 'customerMeasure'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;

    }

    public function edit(Request $request, Measures $measure, $tab = null)
    {
        $customerMeasures = $measure->customerMeasures()->paginate(25);

        if (is_null($measure->customer_ids) || in_array(0, $measure->customer_ids)) {
            $customers = QueryBuilder::for(Customer::class, $request)
                ->allowedFilters([
                    'id', 'name',
                ])
                ->allowedSorts([
                    'id', 'name',
                ])
                ->defaultSort('-id')
                ->paginate(25);
        } else {
            $customers = Customer::whereIn('id', $measure->customer_ids)->paginate(25);
        }

        return view('backend.measures.edit', compact('measure', 'customerMeasures', 'customers', 'tab'));
    }

    public function tabFilterIndex(Request $request, Measures $measure)
    {

        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch', 'filter.trashed'])
        );

        $customerMeasures = $measure->customerMeasures()->paginate(25);
        $state = $filter->input('filter.state');

        if ($state == 'open') {

            $customers = Customer::whereIn('id', $measure->customer_ids)->get();
            $customerArray = [];

            if (! is_null($measure->customer_ids) && in_array(0, $measure->customer_ids)) {

                $customerMeasuresID = CustomerMeasures::all()->pluck('id')->toArray();
                $customers = Customer::whereNotIn('id', $customerMeasuresID)->paginate(25);
            } else {

                foreach ($customers as $customer) {
                    $state = $measure->getMeasureState($customer->id);
                    if ($state == 'offen') {
                        $customerArray[] = $customer->id;
                    }
                }
                $customers = Customer::whereIn('id', $customerArray)->paginate(25);

            }

        } else {

            if (is_null($measure->customer_ids) || in_array(0, $measure->customer_ids)) {

                $customers = QueryBuilder::for(\App\Models\Customer::class, $filter)
                    ->with(['measures'])
                    ->whereHas('measures', function ($query) use ($measure) {
                        $query->where('measure_id', $measure->id);
                    })
                    ->allowedFilters([
                        AllowedFilter::custom('state', new CustomerStateFilter),
                    ])->paginate(25);
            } else {

                $customers = QueryBuilder::for(\App\Models\Customer::class, $filter)
                    ->where('id', $measure->customer_id)
                    ->with(['measures'])
                    ->whereHas('measures', function ($query) use ($measure) {
                        $query->where('measure_id', $measure->id);
                    })->allowedFilters([
                        AllowedFilter::custom('state', new CustomerStateFilter),
                    ])->paginate(25);
            }

        }

        $tab = 'customer';
        $showFilter = true;

        return view('backend.measures.edit', compact('measure', 'customerMeasures', 'customers', 'tab', 'showFilter'));
    }

    public function editCustomer(Request $request, Customer $customer, Measures $measure)
    {
        $modal = 'update';

        $customerMeasure = $measure->customerMeasure($customer->id);

        $view = view('backend.customers.partials.modal.measure.createUpdateForm', compact('modal', 'customer', 'measure', 'customerMeasure'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;
    }

    public function create(Request $request)
    {
        $modal = 'create';

        $view = view('backend.measures.partials.createUpdateForm', compact('modal'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'from' => 'required|date',
            'to' => 'required|date',
            'customer_ids' => 'required',
            'promotion_package' => 'nullable',
            'measure_image' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()])->setStatusCode(200);
        } else {
            $payload = $validator->valid();
        }

        $measure = Measures::create($payload);

        if ($request->hasFile('promotion_package')) {

            $file = $request->file('promotion_package');
            $this->saveFile($measure, $file, 'is_promotion_package');

        }

        if ($request->hasFile('measure_image')) {

            $file = $request->file('measure_image');
            $this->saveFile($measure, $file, 'is_measure_image');

        }

        activity()->performedOn($measure)->causedBy(Auth::user());

        toastr()->success('Die Maßnahme wurde erfolgreich angelegt.');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.measures.index')]);

    }

    public function update(Request $request, Measures $measure)
    {
        $payload = $request->validate([
            'promotion_package' => 'nullable',
            'state' => 'nullable|array',
            'measure_image' => 'nullable',
            'incentivization' => 'nullable|array',
            'from' => 'required|date',
            'to' => 'required|date',
            'customer_measures_dates' => 'nullable|array',
            'customer_measures_dates.*' => 'nullable|array',
            'customer_measures_dates.*.from' => 'nullable|date',
            'customer_measures_dates.*.to' => 'nullable|date',
        ]);

        if ($request->hasFile('promotion_package')) {

            $file = File::find($measure->promotionPackage()->id);

            if (! is_null($file)) {
                $file->delete();
            }

            $file = $request->file('promotion_package');
            $this->saveFile($measure, $file, 'is_promotion_package');
        }

        if ($request->hasFile('measure_image')) {

            $file = File::find($measure->measureImage()->id);

            if (! is_null($file)) {
                $file->delete();
            }

            $file = $request->file('measure_image');
            $this->saveFile($measure, $file, 'is_measure_image');
        }

        foreach ($payload['state'] as $customer_id => $state) {

            $customerMeasure = CustomerMeasures::where('measure_id', $measure->id)->where('customer_id', $customer_id)->first();

            if (! empty($customerMeasure)) {
                if ($customerMeasure->state != $state) {
                    if ($state == Variables::$measuresStates['states']['done'] || $state == Variables::$measuresStates['states']['closed']) {
                        $customerMeasure->update(['to' => Carbon::now()]);
                    }
                    $customerMeasure->update(['state' => $state]);
                }
            } else {
                CustomerMeasures::create([
                    'customer_id' => $customer_id,
                    'measure_id' => $measure->id,
                    'state' => $state,
                    'from' => Carbon::now(),
                    'to' => $measure->to,
                    'causer_id' => Auth::user()->id,
                ]);
            }
        }

        foreach ($payload['incentivization'] as $customer_id => $value) {
            $customerMeasure = CustomerMeasures::where('measure_id', $measure->id)->where('customer_id', $customer_id)->first();

            if (! empty($customerMeasure)) {
                $customerMeasure->update(['incentivization' => $value]);
            }
        }

        $measure->update([
            'from' => $payload['from'],
            'to' => $payload['to'],
        ]);

        if ($payload['customer_measures_dates']) {
            foreach ($payload['customer_measures_dates'] as $customer_id => $dates) {

                if ($dates['from'] && $dates['to']) {
                    $customerMeasure = CustomerMeasures::where('measure_id', $measure->id)->where('customer_id', $customer_id)->first();

                    if (! empty($customerMeasure)) {
                        $customerMeasure->update([
                            'from' => $dates['from'],
                            'to' => $dates['to'],
                        ]);
                    }
                }
            }
        }

        toastr()->success('Die Maßnahme wurde erfolgreich aktualisiert.');

        return redirect()->route('backend.measures.index');
    }

    public function updateOnCustomer(Request $request, Customer $customer, Measures $measure)
    {

        $payload = $request->validate([
            'state' => 'nullable',
            'from' => 'required|date|before:to',
            'to' => 'required|date|after:from',
            'incentivization' => 'required|boolean',
            'coupon' => 'nullable|boolean',
            'cashback' => 'nullable|numeric',
            'cashback_unlimited' => 'nullable',
        ]);

        if (! empty($payload['cashback_unlimited'])) {
            $payload['cashback'] = null;
        }

        $customerMeasure = CustomerMeasures::where('customer_id', $customer->id)->where('measure_id', $measure->id)->first();

        $payload['customer_id'] = $customer->id;
        $payload['measure_id'] = $measure->id;
        $payload['causer_id'] = Auth::user()->id;

        if (! array_key_exists('state', $payload)) {
            $payload['state'] = 'planned';
        }

        if (empty($customerMeasure)) {
            $customerMeasure = CustomerMeasures::create($payload);
            $message = 'Die Maßnahme wurde erfolgreich gebucht.';
        } else {
            $customerMeasure->update($payload);
            $message = 'Die Maßnahme wurde erfolgreich aktualisiert.';
        }

        activity()
            ->performedOn($customerMeasure)
            ->causedBy(Auth::user());

        toastr()->success($message);

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.customers.{customer}.modalTabs', [$customer, 'measures'])])->setStatusCode(200);

    }

    private function saveFile($measure, $file, $fileKey)
    {
        $fileName = hash('sha512', time().$file->get('name').$file->getClientOriginalName());

        if ($file->getMimeType() == 'image/png' || $file->getMimeType() == 'image/jpeg' || $file->getMimeType() == 'image/gif') {
            $path = \Storage::disk('s3_public')->putFileAs('', $file, $file->getClientOriginalName());
        } else {
            $path = \Storage::disk('s3_local')->putFileAs('files', $file, $file->getClientOriginalName());
        }

        $file = File::create([
            'name' => $file->getClientOriginalName(),
            'description' => $fileName,
            'checksum' => md5_file($path),
            'path' => $path,
            'measure_id' => $measure->id,
            'file_type' => $file->getMimeType(),
            $fileKey => 1,
        ]);
    }

    public function showMeasure(Measures $measure)
    {

        $customer = Customer::find(Auth::user()->customer->id);

        return view('backend.measures.show', compact('measure', 'customer'));

    }
}
