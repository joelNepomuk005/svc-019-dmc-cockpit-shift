@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('backend.campaigns', $campaign) }}
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card shadow">
                    <div class="card-body bg-white p-3">
                        <div class="row">
                            <div class="col-12 mt-3">
                                <h5 class="h5">Sparkassen</h5>
                            </div>
                        </div>
                        <div id="filterPostIt" style=" {{ $showFilter ? '' : 'display: none;' }}" class="row mb-5 mt-3 ">
                            <div class="col-6">
                                <div class="sticky-top sticky-top-offset">
                                    <div class="filter">
                                        <form id="filter" method="GET" action="#" name="filter" enctype="multipart/form-data">
                                            @method('POST')
                                            @csrf
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col-6">
                                                            <label class="d-inline-block" for="state"><small>Status</small></label>
                                                            <div class="form-floating">
                                                                <select class="selectpicker w-100 btn-block" name="filter[state]" id="filter_state">
                                                                    <option value="" {{ !is_null(@old('filter.state', request('filter.state'))) ? @old('filter.state', request('filter.state')) == '' ? 'selected' : '' : ''}}>Bitte auswählen...</option>
                                                                    @foreach(\App\Enums\Variables::$measuresStates['states'] as $key => $state)
                                                                        <option value="{{ $key }}" {{ @old('filter.state', request('filter.state')) == $key ? 'selected' : '' }}>{{ $state['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-accent">
                                                    <div class="row mt-3 mb-2">
                                                        <div class="col-4">
                                                            <button class="btn btn-secondary btn-sm d-block w-100 waves-effect waves-light" name="filter-submit" type="submit"><i class="fas fa-filter me-2" aria-hidden="true"></i><span class="d-xs-none">Filter anwenden</span></button>
                                                        </div>
                                                        <div class="col-4">
                                                            <a href="{{ route('backend.campaigns.{campaign}.edit', ['campaign' => $campaign, 'tab' => 'sparkasse']) }}" class="btn btn-link btn-sm d-block w-100 text-black-50 text-decoration-none" name="filter-reset"><i class="fas fa-times me-2" aria-hidden="true"></i><span class="d-xs-none">Filter zurücksetzen</span></a>
                                                        </div>
                                                        <div class="col-4">
                                                            <a href="#" id="close-filter" class="btn btn-link btn-sm d-block w-100 text-black-50 text-decoration-none" name="filter-reset"><i class="fas fa-window-close me-2" aria-hidden="true"></i><span class="d-xs-none">Fenster schließen</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{route('backend.campaigns.{campaign}.update', $campaign)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row d-flex">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-9 col-xxl-9 p-3 align-self-stretch">
                                    <div class="tab-content vertical">
                                        <div class="tab-pane fade in {{ is_null($tab) ? 'show active' : '' }} " id="form-tab-1" role="tabpanel">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-6">
                                                            <header>
                                                                <h3 class="h5">Übersicht <small>({{ $campaign->name }})</small></h3>
                                                            </header>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group form-floating mb-3">
                                                        <input id="prefix" type="text" class="form-control" name="prefix" value="{{ !empty($campaign->prefix) ? $campaign->prefix : ''}}" required>
                                                        <label for="prefix" class="active">Prefix<sup>*</sup></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group form-floating mb-3">
                                                        <input id="name" type="text" class="form-control" name="name" value="{{ !empty($campaign->name) ? $campaign->name : ''}}">
                                                        <label for="name" class="active">Name <sup>*</sup></label>
                                                    </div>
                                                    @if ($errors->has('name'))
                                                        <div class="error-message" id="name">
                                                            <div class="alert alert-danger" role="alert"><p>{{ $errors->first('name') }}</p></div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group form-floating mb-3">
                                                        <input id="title" type="text" class="form-control" name="title" value="{{ !empty($campaign->title) ? $campaign->title : ''}}" required>
                                                        <label for="title" class="active">Titel<sup>*</sup></label>
                                                    </div>
                                                    @if ($errors->has('title'))
                                                        <div class="error-message" id="title">
                                                            <div class="alert alert-danger" role="alert"><p>{{ $errors->first('title') }}</p></div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="form-group form-floating mb-3">
                                                        <textarea id="subheadline" type="text" class="form-control" name="subheadline" style="height: 150px" required>{{ !empty($campaign->subheadline) ? $campaign->subheadline : ''}}</textarea>
                                                        <label for="subheadline" class="active">Subheadline <sup>*</sup></label>
                                                    </div>
                                                    @if ($errors->has('subheadline'))
                                                        <div class="error-message" id="subheadline">
                                                            <div class="alert alert-danger" role="alert"><p>{{ $errors->first('subheadline') }}</p></div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group form-floating mb-3">
                                                        <input id="link" type="text" class="form-control" name="link" value="{{ !empty($campaign->link) ? $campaign->link : ''}}">
                                                        <label for="link" class="active">Link <sup>*</sup></label>
                                                    </div>
                                                </div>
                                                @if ($errors->has('link'))
                                                    <div class="error-message" id="link">
                                                        <div class="alert alert-danger" role="alert"><p>{{ $errors->first('link') }}</p></div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group form-floating mb-3">
                                                        <input id="start_date" type="date" class="form-control" name="start_date" value="{{ !empty($campaign->start_date) ? $campaign->start_date->format('Y-m-d') : '' }}" required>
                                                        <label for="start_date" class="active">Von <sup>*</sup></label>
                                                    </div>
                                                    @if ($errors->has('start_date'))
                                                        <div class="error-message" id="start_date">
                                                            <div class="alert alert-danger" role="alert"><p>{{ $errors->first('start_date') }}</p></div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group form-floating mb-3">
                                                        <input id="end_date" type="date" class="form-control" name="end_date" value="{{ !empty($campaign->end_date) ? $campaign->end_date->format('Y-m-d') : '' }}" required>
                                                        <label for="end_date" class="active">Bis <sup>*</sup></label>
                                                    </div>
                                                    @if ($errors->has('end_date'))
                                                        <div class="error-message" id="end_date">
                                                            <div class="alert alert-danger" role="alert"><p>{{ $errors->first('end_date') }}</p></div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group form-floating mb-3">
                                                        <select name="customer_ids[]" id="customer_ids" class="selectpicker w-100 btn-block" multiple aria-label="size 3 select example" title="Institute" data-live-search="true" data-done-button="true" data-done-button-text="Schließen">
                                                            <option value="0" id="select-all-option">Alle</option>
                                                            @foreach(\App\Models\Customer::all() as  $customer)
                                                                <option value="{{$customer->id}}" {{ !is_null($campaignParticipantsIds)  ? in_array($customer->id, $campaignParticipantsIds) ? 'selected' : '' : ''}}>{{$customer->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="row">
                                                    <label class="custom-file-label" for="file">Excel-Datei für Sparkassen-Upload auswählen</label>
                                                    <div class="col-4">
                                                        <div class="form-group form-floating mb-3">
                                                            <input type="file" id="customer_upload" name="customer_upload" placeholder="Excel-Datei auswählen..." class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @if (!empty($campaign->images))
                                                    <div class="row">
                                                        @foreach ($campaign->images as $image)
                                                            <div class="col-md-4 mb-4">
                                                                <div class="position-relative">
                                                                    <img src="{{ $image }}" alt="Bild" class="img-fluid campaign-preview-image">
                                                                    <button class="delete-image-btn" data-image="{{ $image }}" style="position: absolute; top: 10px; right: 10px; background-color: #fff; border-radius: 50%;">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                @else
                                                    <p>Es wurden keine Bilder gefunden.</p>
                                                @endif

                                                <div class="row">
                                                    <div class="row">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label class="custom-file-label" for="file">
                                                                    Bilder für den Wettbewerb auswählen
                                                                    <i class="fa fa-info-circle" style="color: grey !important;" data-bs-toggle="tooltip" data-bs-placement="right" title="Bitte laden Sie nur Bilder im Format 2400px x 1050px hoch"></i>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group form-floating mb-3">
                                                            <input type="file" id="campaign_images" name="campaign_images[]" placeholder="Datei auswählen oder ablegen..." class="form-control" multiple>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @method('PUT')
                                            <div class="row">
                                                {{--@if (!is_null($campaign->images()))
                                                    <label class="custom-file-label" for="file">Wettbewerbs Bilder ändern</label>
                                                    <div class="col-md-6 remove-file">

                                                    </div>
                                                @endif--}}
                                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 col-xxl-3 align-self-stretch">
                <div class="d-flex align-items-start py-3 h-75">
                    <div class="w-100">
                        <ul class="nav nav-pills nav-fill nav-pills-vertical navbar-light text-center flex-column" role="tablist" aria-orientation="vertical">
                            <li class="nav-item px-0"><a class="nav-link {{ is_null($tab) ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#form-tab-1" type="button" role="tab" aria-controls="" aria-selected="true">Übersicht</a></li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex align-items-end h-25">
                    <div class="w-100 py-3 px-3">
                                            <span data-double-submit role="button" class="d-flex w-100">
                                                <span class="locked d-block w-100 justify-content-center">
                                                    <button type="button" role="button" data-alert="" class="btn d-block btn-link w-100">
                                                        <i aria-hidden="true" class="me-2 fas fa-lock"></i>Abbrechen?
                                                    </button>
                                                </span>
                                                <span role="button" class="unlocked d-none w-100">
                                                    <span class="btn-group d-flex justify-content-center w-100" role="group" aria-label="">
                                                        <button type="button" role="button" data-submit="link||{{route('backend.campaigns.index')}}" class="btn btn-dark px-3">ja</button>
                                                        <button type="button" role="button" data-cancel="" class="btn btn-dark px-3">nein</button>
                                                        <span class="btn btn-primary flex-grow-3 px-3"><i aria-hidden="true" class="d-inline-block me-2 fa fa-lock-open"></i>Abbrechen</span>
                                                    </span>
                                                </span>
                                            </span>
                        <hr>
                        <button type="submit" class="btn btn-primary text-white d-block w-100">Speichern</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    </div>
    </div>



@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $(".delete-image-btn").on("click", function () {
                if (confirm("Möchten Sie dieses Bild wirklich löschen?")) {
                    var imageSrc = $(this).data("image");
                    var campaignId = "{{ $campaign->id }}";

                    //console.log(campaignId);
                    $.ajax({
                        url: "{{ route('backend.campaigns.{campaign}.deleteCampaignPicture', ['campaign' => $campaign]) }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            imageSrc: imageSrc
                        },
                    });
                }
            });
        });
    </script>
    @endpush
