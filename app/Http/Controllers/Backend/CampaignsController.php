<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Imports\CustomerToArray;
use App\Models\Campaign;
use App\Models\CampaignParticipants;
use App\Models\Customer;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;
use Spatie\QueryBuilder\QueryBuilder;

class CampaignsController extends Controller
{
    public function index(Request $request): View
    {

        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch'])
        );

        $campaigns = QueryBuilder::for(Campaign::class, $filter)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['id', 'name'])
            ->defaultSort('-id')
            ->paginate(\request('per_page', 25));

        return view('backend.campaigns.overview', compact('campaigns'));
    }

    public function create(Request $request)
    {
        $modal = 'create';

        $view = view('backend.campaigns.partials.createUpdateForm', compact('modal'))->render();

        $response = \Response::make($view, 200);
        $response->header('Content-Type', 'text/html');

        return $response;
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:55',
            'subheadline' => 'required|string|max:110',
            'link' => 'nullable',
            'prefix' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'customer_ids' => 'required_if:customer_upload,null',
            'campaign_images.*' => 'image|mimes:jpeg,bmp,png,jpg,svg|max:2000',
            'customer_upload' => 'required_if:customer_ids,null',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()])->setStatusCode(200);
        } else {
            $payload = $validator->valid();
        }

        if ($request->hasFile('customer_upload')) {

            $payload['customer_ids'] = $this->getUploadedCustomersBlz(request()->file('customer_upload'));

        } elseif (in_array(0, $payload['customer_ids'])) {
            $payload['customer_ids'] = Customer::all()->pluck('id')->toArray();
        }

        if ($request->hasFile('campaign_images')) {
            $images = [];
            foreach ($payload['campaign_images'] as $image) {
                $images[] = $this->saveFile($image, 'is_campaign_image');
            }
        }

        $startDate = Carbon::parse($payload['start_date']);
        $endDate = Carbon::parse($payload['end_date']);

        $campaign = Campaign::create([
            'uuid' => Uuid::uuid4()->toString(),
            'name' => $payload['name'],
            'title' => $payload['title'],
            'subheadline' => $payload['subheadline'],
            'link' => $payload['link'],
            'prefix' => $payload['prefix'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'images' => $images,
        ]);

        $createdCampaignParticipants = [];

        foreach ($payload['customer_ids'] as $customer_id) {

            $customer = Customer::where('id', $customer_id)->first();

            CampaignParticipants::create([
                'campaign_id' => $campaign->id,
                'customer_id' => $customer->id,
                'blz' => $customer->blz,
            ]);

            $createdCampaignParticipants[] = $customer;
        }

        // $this->sendCampaignDataToLandingpage($campaign, $createdCampaignParticipants, 'create');

        toastr()->success('Der Wettbewerb wurde erfolgreich angelegt.');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.campaigns.index')]);

    }

    public function sendCampaignDataToLandingpage(Campaign $campaign, $campaignParticipants, $type): JsonResponse
    {
        Log::info('Started Send Campaign to Landingpage!');
        $bearerToken = env('API_BEARER_TOKEN');
        Log::info('Bearer Token: '.$bearerToken);

        $requestData = [
            'campaign' => $campaign,
            'campaignParticipants' => $campaignParticipants,
        ];

        if ($type == 'create') {
            $url = env('API_SVC_008_URL').'/api/store-campaign';
        } elseif ($type == 'update') {
            $url = env('API_SVC_008_URL').'/api/update-campaign';
        } else {
            $url = env('API_SVC_008_URL').'/api/delete-campaign';
            $response = Http::withHeaders(['Authorization' => 'Bearer '.$bearerToken])->delete($url, $requestData);

            if ($response->successful()) {
                Log::info('Update Campaign triggered successfull!');

                return response()->json(['status' => 'success'])->setStatusCode(200);
            } else {
                Log::info($response->body());

                return response()->json(['status' => 'error'])->setStatusCode(200);
            }
        }

        $response = Http::withHeaders(['Authorization' => 'Bearer '.$bearerToken])->post($url, $requestData);

        if ($response->successful()) {
            Log::info($response->json());
            $responseData = $response->json();
        } else {
            Log::info($response->body());
            $errorMessage = $response->body();
        }
    }

    public function edit(Request $request, Campaign $campaign): View
    {
        $filter = new \Illuminate\Http\Request(
            $request->except(['filter.customSearch', 'filter.trashed'])
        );

        $campaignParticipants = QueryBuilder::for(CampaignParticipants::class, $filter)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['id', 'name'])
            ->where('campaign_id', $campaign->id);

        $campaignParticipantsIds = $campaignParticipants->get()->pluck('customer_id')->toArray();

        if (\request('filter.customSearch')) {
            $campaignParticipants->customSearch(request('filter.customSearch'));
        }

        $campaignParticipants = $campaignParticipants->paginate(\request('per_page', 25));

        return view('backend.campaigns.edit', compact('campaign', 'campaignParticipants', 'campaignParticipantsIds'));
    }

    public function update(Request $request, Campaign $campaign): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:55',
            'subheadline' => 'required|string|max:110',
            'link' => 'nullable',
            'prefix' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'customer_ids' => 'required_if:customer_upload,null',
            'campaign_images.*' => 'nullable',
            'customer_upload' => 'required_if:customer_ids,null',
        ]);

        if ($validator->fails()) {
            toastr()->error('Bitte füllen Sie alle Felder korrekt aus');

            return redirect()->route('backend.campaigns.{campaign}.edit', $campaign)->withErrors($validator);

        } else {
            $payload = $validator->valid();
        }

        if ($request->hasFile('campaign_images')) {
            $images = [];
            foreach ($payload['campaign_images'] as $image) {
                $images[] = $this->saveFile($image, 'is_campaign_image');
            }
        } else {

            if (! is_null($campaign->images)) {
                foreach ($campaign->images as $image) {
                    $images[] = $image;
                }
            } else {
                $images = null;
            }
        }

        if ($request->hasFile('customer_upload')) {

            $payload['customer_ids'] = $this->getUploadedCustomersBlz(request()->file('customer_upload'));

        } elseif (in_array(0, $payload['customer_ids'])) {
            $payload['customer_ids'] = Customer::all()->pluck('id')->toArray();
        }

        $startDate = Carbon::parse($payload['start_date']);
        $startDate = $campaign->serializeDate($startDate);

        $endDate = Carbon::parse($payload['end_date']);
        $endDate = $campaign->serializeDate($endDate);

        $campaign->name = $payload['name'];
        $campaign->title = $payload['title'];
        $campaign->subheadline = $payload['subheadline'];
        $campaign->link = $payload['link'];
        $campaign->prefix = $payload['prefix'];
        $campaign->start_date = $startDate;
        $campaign->end_date = $endDate;
        $campaign->images = $images;
        $campaign->save();

        $campaignParticipants = CampaignParticipants::where('campaign_id', $campaign->id)->delete();

        $createdCampaignParticipants = [];

        foreach ($payload['customer_ids'] as $customer_id) {

            $customer = Customer::where('id', $customer_id)->first();

            CampaignParticipants::create([
                'campaign_id' => $campaign->id,
                'customer_id' => $customer->id,
                'blz' => $customer->blz,
            ]);

            $createdCampaignParticipants[] = $customer;
        }

        // $this->sendCampaignDataToLandingpage($campaign, $createdCampaignParticipants, 'update');

        toastr()->success('Wettbewerb wurde erfolgreich aktualisiert.');

        return redirect()->route('backend.campaigns.{campaign}.edit', $campaign);

    }

    public function getUploadedCustomersBlz($request)
    {
        $uploadedCustomer = Excel::toArray(new CustomerToArray, $request);
        $customer['customer_ids'] = [];

        foreach ($uploadedCustomer[0] as $key => $value) {

            if (is_numeric($value[0])) {
                $customerID = Customer::where('blz', $value[0])->value('id');

                if ($customerID !== null) {
                    $customer['customer_ids'][] = $customerID;
                }
            }
        }

        return $customer['customer_ids'];
    }

    public function destroy(Request $request, Campaign $campaign): JsonResponse
    {

        // $this->sendCampaignDataToLandingpage($campaign, null, 'delete');
        $campaignParticipants = CampaignParticipants::where('campaign_id', $campaign->id)->delete();
        $campaign->delete();

        toastr()->success('Der Wettbewerb wurde erfolgreich gelöscht.');

        return response()->json([
            'success' => true,
        ]);

    }

    private function saveFile($file, $fileKey)
    {
        $fileName = hash('sha512', time().$file->get('name').$file->getClientOriginalName());

        $path = \Storage::disk('s3_public')->putFileAs('images', $file, $file->getClientOriginalName());

        $file = File::create([
            'name' => $file->getClientOriginalName(),
            'description' => $fileName,
            'checksum' => md5_file($path),
            'path' => $path,
            'file_type' => $file->getMimeType(),
            $fileKey => 1,
        ]);

        return Storage::disk('s3_public')->url($path);
    }

    public function deleteCampaignPicture(Request $request, $campaignId)
    {

        $imageSrc = $request->input('imageSrc');
        $campaign = Campaign::find($campaignId);
        $images = $campaign->images;

        $updatedImages = array_filter($images, function ($image) use ($imageSrc) {
            return $image !== $imageSrc;
        });

        if (empty($updatedImages)) {
            $campaign->images = null;
        } else {
            $campaign->images = array_values($updatedImages);
        }

        $campaign->save();

        $campaignParticipants = [];

        foreach (CampaignParticipants::where('campaign_id', $campaign->id)->get() as $participant) {

            $customer = Customer::where('id', $participant->id)->first();
            $campaignParticipants[] = $customer;
        }

        // $this->sendCampaignDataToLandingpage($campaign, $campaignParticipants, 'update');

        toastr()->success('Bild erfolgreich gelöscht');

        return response()->json(['status' => 'success', 'type' => 'redirect', 'redirect_url' => route('backend.campaigns.{campaign}.edit', $campaign)])->setStatusCode(200);

    }
}
