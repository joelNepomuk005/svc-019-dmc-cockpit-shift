@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('backend.customer.show', $customer) }}
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card shadow">
                    <div class="card-body bg-white px-0 py-0">
                        <div class="row d-flex">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-9 col-xxl-9 p-3 align-self-stretch">
                                <div class="p-4">
                                    <div class="tab-content vertical">
                                        <div class="tab-pane fade in show active" id="form-tab-1" role="tabpanel">
                                            @include('backend.measures.partials.general')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 col-xxl-3 align-self-stretch bg-accent border-left border-light">
                                <div class="d-flex align-items-start py-4 h-75">
                                    <div class="w-100">
                                        <ul class="nav nav-pills nav-fill nav-pills-vertical navbar-light text-center flex-column" role="tablist" aria-orientation="vertical">
                                            <li class="nav-item px-0 mb-4"><a class="nav-link {{ is_null($tab) ? 'active' : ''}}" data-bs-toggle="tab" data-bs-target="#form-tab-1" type="button" role="tab" aria-controls="" aria-selected="true">Übersicht</a></li>
                                            @if (!empty($measure->promotionPackage()))
                                                <a href="{{ route('backend.files.downloadFile', $measure->promotionPackage()) }}" class="btn btn-outline-primary">Kampagnen-Dokumente herunterladen</a>
                                            @else
                                                <a href="#" class="btn btn-outline-primary"> <i class="fa fa-info-circle"  style="color: grey !important;"  data-bs-toggle="tooltip" data-bs-placement="right" title="Die Werbemittel werden rechtzeitig vor Kampagnenstart zum Download bereitgestellt"></i></a>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end h-25">
                                    <div class="w-100 py-3 px-3">
                                        <div class="border-bottom pb-3">
                                            <div data-double-submit role="button" class="d-flex w-100">
                                                <div class="locked d-block w-100 justify-content-center">
                                                    <button type="button" role="button" data-alert="" class="btn d-block btn-link text-black w-100">
                                                        <i aria-hidden="true" class="me-2 fas fa-lock"></i>Abbrechen?
                                                    </button>
                                                </div>
                                                <div role="button" class="unlocked d-none w-100">
                                                    <div class="btn-group d-flex justify-content-center w-100" role="group" aria-label="">
                                                        <button type="button" role="button" data-submit="link||{{ route('backend.dashboard.index') }}" class="btn btn-dark px-3">Ja</button>
                                                        <button type="button" role="button" data-cancel="" class="btn btn-dark px-3">Nein</button>
                                                        <span class="btn btn-primary flex-grow-3 px-3"><i aria-hidden="true" class="d-inline-block me-2 fa fa-lock-open"></i>Abbrechen</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-top pt-3">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" role="switch" id="ava" name="ava" value="0" class="form-check-input" required>
                                                        <label class="form-check-label" for="ava">Wir nehmen zur Kenntnis: Es gilt die AVA im Verhältnis zur S-Markt & Mehrwert GmbH & Co. KG.<br>Diese gilt bis zum Widerruf des Auftrags.
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($measure->getMeasureState(Auth::user()->customer->id) == 'offen')
                                                <a id="btnCreateMeasureModal" data-bs-toggle="modal" data-bs-target="#createMeasureModal" href="{{ route('backend.customers.{customer}.measures.{measure}.editCustomer', [$customer, $measure]) }}" data-ajax class="btn btn-primary d-block w-100 disabled">Maßnahme buchen</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script type="text/javascript">
            $(document).ready(function() {
                // Disable Modal if not Checked
                $('#ava').change(function () {
                    let btn = $('#btnCreateMeasureModal');
                    if (this.checked) {
                        btn.removeClass('disabled');
                    } else {
                        btn.addClass('disabled');
                    }
                });
            });
        </script>
    @endpush

@endsection
