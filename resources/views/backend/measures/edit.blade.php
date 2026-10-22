@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('backend.measures.edit', $measure) }}
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card shadow">
                    <div class="card-body bg-white px-0 py-0">
                        @if($errors->any())
                            <div class="alert alert-warning" role="alert">
                                {!! implode('', $errors->all('<div>:message</div>')) !!}
                            </div>
                        @endif


                        <div id="filterPostIt" style=" {{ $showFilter ? '' : 'display: none;' }}" class="row mb-5 mt-3 ">
                            <div class="col-6">
                                <div class="sticky-top sticky-top-offset">
                                    <div class="filter">
                                        <form id="filter" method="GET" action="{{ route('backend.measures.{measure}.filter', $measure) }}" name="filter" enctype="multipart/form-data">
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
                                                            <a href="{{ route('backend.measures.{measure}.edit', ['measure' => $measure, 'tab' => 'sparkasse']) }}" class="btn btn-link btn-sm d-block w-100 text-black-50 text-decoration-none" name="filter-reset"><i class="fas fa-times me-2" aria-hidden="true"></i><span class="d-xs-none">Filter zurücksetzen</span></a>
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

                        <form action="{{route('backend.measures.{measure}.update', $measure)}}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row d-flex">


                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-9 col-xxl-9 p-3 align-self-stretch">
                                    <div class="p-4">
                                        <div class="tab-content vertical">
                                            <div class="tab-pane fade in show active" id="form-tab-1" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <div class="col-6">
                                                                <header>
                                                                    <h3 class="h5">Übersicht <small>({{ $measure->name }})</small></h3>
                                                                </header>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <dl class="row highlight-dd">
                                                            <dt class="col-5">Kampagne</dt>
                                                            <dd class="col-7">{{ $measure->name }}</dd>
                                                            <dt class="col-5">Datum</dt>
                                                            <dd>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group form-floating mb-3">
                                                                            <input id="from" type="date" class="form-control" name="from" value="{{ !empty($measure->from->format('Y-m-d')) ? $measure->from->format('Y-m-d') : ''}}">
                                                                            <label for="from" class="active">Von<sup>*</sup></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group form-floating mb-3">
                                                                            <input id="to" type="date" class="form-control" name="to" value="{{ !empty($measure->to->format('Y-m-d')) ? $measure->to->format('Y-m-d') : ''}}">
                                                                            <label for="to" class="active">Bis <sup>*</sup></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </dd>
                                                            <dt class="col-5">Anmeldungen Sparkassen</dt>
                                                            <dd class="col-7">{{ $measure->customerMeasures->count() }}</dd>
                                                            <dt class="col-5">Selektierte Kunden</dt>
                                                            <dd class="col-7"></dd>
                                                            <dt class="col-5">Incentivierte Kunden</dt>
                                                            <dd class="col-7">{{ $measure->customerIncentivization->count() }}</dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @if (!is_null($measure->promotionPackage()))
                                                        <label class="custom-file-label" for="file">Werbemittelpaket ändern</label>
                                                        <div class="col-md-6 remove-file">
                                                            <span class="badge bg-secondary"><a href="{{ route('backend.files.downloadFile', $measure->promotionPackage()) }}" class="text-white text-decoration-none"><i class="fa fa-download me-1"></i>{{ $measure->promotionPackage()->name }}</a> <a id="{{$measure->promotionPackage()->id}}" class="deleteFile text-white"><i class="fa fa-times ms-2"></i></a></span>
                                                        </div>
                                                    @endif
                                                    <div class="row">
                                                        @if (is_null($measure->promotionPackage()))
                                                            <label class="custom-file-label" for="file">Werbemittelpaket auswählen</label>
                                                        @endif
                                                        <div class="col-6">
                                                            <div class="form-group form-floating mb-3">
                                                                <input type="file" id="promotion_package" name="promotion_package" placeholder="Datei auswählen oder ablegen..." class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        @if (!is_null($measure->measureImage()))
                                                            <label class="custom-file-label" for="file">Bild für die Maßnahme ändern</label>
                                                            <div class="col-md-6 remove-file">
                                                                <img class="measure-image" src="{{ \Illuminate\Support\Facades\Storage::disk('s3_public')->url($measure->measureImage()->name) }}" alt="Maßnahmenbild">
                                                            </div>
                                                        @endif
                                                        <div class="row">
                                                            @if (is_null($measure->measureImage()))
                                                                <label class="custom-file-label" for="file">Bild für die Maßnahme auswählen</label>
                                                            @endif
                                                            <div class="col-6 mt-2">
                                                                <div class="form-group form-floating mb-3">
                                                                    <input type="file" id="measure_image" name="measure_image" placeholder="Datei auswählen oder ablegen..." class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade in {{ !is_null($tab) ? 'show active' : '' }}" id="form-tab-2" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-12">
                                                        @if(is_countable($customers) && count($customers) > 0)
                                                            <table class="table table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th>Sparkasse</th>
                                                                    <th>Status</th>
                                                                    <th>Status ändern</th>
                                                                    <th>anmeldende Person</th>
                                                                    <th>Start-Datum</th>
                                                                    <th>End-Datum</th>
                                                                    <th>Incentivierung</th>
                                                                    <th>Cashback</th>
                                                                    <th>Cashback unbegrenzt</th>
                                                                </tr>
                                                                <div class="d-flex justify-content-end">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-link btn-sm text-black text-decoration-none dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            Aktionen<i class="ms-2 fas fa-ellipsis-v" aria-hidden="true"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                            <li><a id="exportCustomerExcel" href="{{ route('backend.reports.{measure}.excel_export_measure_customers', $measure) }}" class="dropdown-item"><i class="me-2 far fa-list" aria-hidden="true"></i>Excel-Datei exportieren</a></li>
                                                                            <li> <a id="filterButtonPostIt" class="dropdown-item" href="#" data-ajax><i class="me-2 far fa-filter" aria-hidden="true"></i> Filter</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($customers as $customer)
                                                                    <tr>
                                                                        <td><a href="{{ route('backend.customers.{customer}.show', $customer->id) }}">{{ $customer->name  }}</a></td>
                                                                        <td>{!! $measure->getBadgeInformation($customer->id) !!}</td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <select class="form-control" id="state" name="state[{{ $customer->id }}]">
                                                                                    @foreach(\App\Enums\Variables::$measuresStates['states'] as $key => $state)
                                                                                        <option value="{{ $key }}" {{ old('state.'.$customer->id, $measure->customerMeasure($customer->id)->state) == $key ? 'selected' : '' }} {{ $key == 'open' ? 'disabled' : '' }} {{ empty($measure->customerMeasure($customer->id)) && $key == 'open' ? 'selected' : '' }}>{{ $state['name'] }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            @if(!empty($measure->customerMeasure($customer->id)))
                                                                            {{$measure->customerMeasure($customer->id)->causer()->name}}
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <input id="customer_measures_dates[{{$customer->id}}][from]" type="date" name="customer_measures_dates[{{$customer->id}}][from]" class="form-control" value="{{ old('customer_measures_dates.'.$customer->id.'.from', $measure->customerMeasure($customer->id)->from) ? $measure->customerMeasure($customer->id)->from->format('Y-m-d') : '' }}" >
                                                                        </td>
                                                                        <td>
                                                                            <input id="customer_measures_dates[{{$customer->id}}][to]" type="date" name="customer_measures_dates[{{$customer->id}}][to]" class="form-control" value="{{ old('customer_measures_dates.'.$customer->id.'to', $measure->customerMeasure($customer->id)->to) ? $measure->customerMeasure($customer->id)->to->format('Y-m-d') : '' }}" >
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <select class="form-control" id="incentivization" name="incentivization[{{$customer->id}}]" {{ empty($measure->customerMeasure($customer->id)) ? 'disabled' : '' }}>
                                                                                    <option value="1" {{ $measure->customerMeasure($customer->id)->incentivization == 1 ? 'selected' : '' }}>Ja</option>
                                                                                    <option value="0" {{ $measure->customerMeasure($customer->id)->incentivization == 0 ? 'selected' : '' }}>Nein</option>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td>{{ !empty($measure->customerMeasure($customer->id)->cashback) ? $measure->customerMeasure($customer->id)->cashback . ' €' : '- keine Angabe -' }}</td>
                                                                        <td>{{ !empty($measure->customerMeasure($customer->id)->cashback_unlimited) ? $measure->customerMeasure($customer->id)->cashback_unlimited == '1' ? 'Ja' : 'Nein' : '- keine Angabe -' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            <div class="alert alert-info" role="alert">
                                                                <section>
                                                                    <h4 class="alert-heading h5">Hinweis</h4>
                                                                    <p>
                                                                        Derzeit sind keine Teilnehmer verfügbar.
                                                                    </p>
                                                                </section>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row-cols-1">
                                                    @if (!$customers->isEmpty())
                                                        <div class="row d-flex align-items-center py-2">
                                                            <div class="col-6">
                                                                <span role="status" aria-live="polite">Zeige {{ $customers->firstItem() }} bis {{ $customers->lastItem() }} von {{ $customers->total() }} Ergebnissen</span>
                                                            </div>
                                                            <div class="col-6">
                                                                <nav aria-label="Seitensteuerung für Tabelle">
                                                                    {{ $customers->appends(['per_page' => request('per_page', 25), 'filter' => request('filter'), 'sort' => request('sort'), 'search' => request('search')])->links() }}
                                                                </nav>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 col-xxl-3 align-self-stretch bg-accent border-left border-light">
                                    <div class="d-flex align-items-start py-3 h-75">
                                        <div class="w-100">
                                            <ul class="nav nav-pills nav-fill nav-pills-vertical navbar-light text-center flex-column" role="tablist" aria-orientation="vertical">
                                                <li class="nav-item px-0"><a class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tab-1" type="button" role="tab" aria-controls="" aria-selected="true">Übersicht</a></li>
                                                <li class="nav-item px-0"><a class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tab-2" type="button" role="tab" aria-controls="" aria-selected="true">Sparkassen</a></li>
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
                                                    <button type="button" role="button" data-submit="link||{{route('backend.customers.index')}}" class="btn btn-dark px-3">ja</button>
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
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>


    @push('js')
        <script type="text/javascript">
            $( document ).ready(function() {
                $('.deleteFile').on('click', function () {
                    if (confirm("Möchten Sie die Datei wirklich löschen?")) {
                        axios.post('/backend/files/' + $(this).attr('id'), {_method: 'delete'})
                            .then(res => {
                                $(this).closest('.remove-file').remove();
                            }).catch(err => {
                            console.log(err)
                        })
                    }
                });
            });

            $("#close-filter").click(function() {
                $("#filterPostIt").fadeToggle( "fast", "linear" );
            });
            $("#filterButtonPostIt").click(function() {
                $("#filterPostIt").fadeToggle( "fast", "linear" );
            });
        </script>
    @endpush
@endsection
