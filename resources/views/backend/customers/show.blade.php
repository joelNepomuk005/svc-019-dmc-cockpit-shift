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
                                        <div class="tab-pane fade in show {{ is_null($tab) ? 'active' : '' }}" id="form-tab-1" role="tabpanel">
                                            @include('backend.customers.partials.general')
                                        </div>
                                        @can('main_menu_contacts')
                                        <div class="tab-pane fade in show {{!is_null($tab) && $tab == 'contacts' ? 'active' : ''}}" id="form-tab-2" role="tabpanel">
                                            @include('backend.customers.partials.contacts')
                                        </div>
                                        @endcan
                                        @can('main_menu_persons')
                                        <div class="tab-pane fade in show {{!is_null($tab) && $tab == 'users' ? 'active' : ''}}" id="form-tab-3" role="tabpanel">
                                            @include('backend.customers.partials.user')
                                        </div>
                                        @endcan
                                        <div class="tab-pane fade in show {{!is_null($tab) && $tab == 'measures' ? 'active' : ''}}" id="form-tab-4" role="tabpanel">
                                            @include('backend.customers.partials.measures')
                                        </div>
                                        <div class="tab-pane fade in show {{!is_null($tab) && $tab == 'budgets' ? 'active' : ''}}" id="form-tab-5" role="tabpanel">
                                            @include('backend.customers.partials.budgets')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 col-xxl-3 align-self-stretch bg-accent border-left border-light">
                                <div class="d-flex align-items-start py-4 h-75">
                                    <div class="w-100">
                                        <ul class="nav nav-pills nav-fill nav-pills-vertical navbar-light text-center flex-column" role="tablist" aria-orientation="vertical">
                                            <li class="nav-item px-0"><a class="nav-link {{ is_null($tab) ? 'active' : ''}}" data-bs-toggle="tab" data-bs-target="#form-tab-1" type="button" role="tab" aria-controls="" aria-selected="true">Übersicht</a></li>
                                            @can('main_menu_contacts')
                                            <li class="nav-item px-0"><a class="nav-link {{!is_null($tab) && $tab == 'contacts' ? 'active' : ''}}" data-bs-toggle="tab" data-bs-target="#form-tab-2" type="button" role="tab" aria-controls="" aria-selected="true">Kontakte</a></li>
                                            @endcan
                                            @can('main_menu_persons')
                                            <li class="nav-item px-0"><a class="nav-link {{!is_null($tab) && $tab == 'users' ? 'active' : ''}}" data-bs-toggle="tab" data-bs-target="#form-tab-3" type="button" role="tab" aria-controls="" aria-selected="true">Personen</a></li>
                                            @endcan
                                            <li class="nav-item px-0"><a class="nav-link {{!is_null($tab) && $tab == 'measures' ? 'active' : ''}}" data-bs-toggle="tab" data-bs-target="#form-tab-4" type="button" role="tab" aria-controls="" aria-selected="true">Maßnahmen</a></li>
                                            <li class="nav-item px-0"><a class="nav-link {{!is_null($tab) && $tab == 'budgets' ? 'active' : ''}}" data-bs-toggle="tab" data-bs-target="#form-tab-5" type="button" role="tab" aria-controls="" aria-selected="true">Budgetverwaltung</a></li>
                                            </ul>
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