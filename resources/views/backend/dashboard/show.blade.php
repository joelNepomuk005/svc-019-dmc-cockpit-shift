@extends('layouts.backend')

@section('content')

    @can('home_see_overview')


        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        {{ Breadcrumbs::render('home') }}
                    </nav>
                </div>
                @include('backend.quicklinks')
            </div>
            <div class="row mb-5">
                <div class="col-12">
                    <header>
                        <h1 class="h3 text-red"> Guten Tag und willkommen <b>{{ \Auth::User()->name }}</b>.</h1>
                        <p class="lead">
                            Hier finden Sie eine Übersicht über die kommenden Kampagnen und können auch die Werbemittel sowie die Zielkunden-Selektionen rechtzeitig vor Kampagnenstart downloaden.<br>
                            Zudem behalten Sie im DMC-Cockpit stets den Überblick über Ihr bereits eingesetztes und noch zur Vefügung stehendes Budget.
                        </p>
                    </header>
                </div>
            </div>
            <div class="row mb-5">
                @include('backend.dashboard.partials.measures')
                @include('backend.dashboard.partials.chart')
            </div>
            @include('backend.dashboard.partials.links')

            <div class="row">
                @include('backend.dashboard.partials.customers')
                @include('backend.dashboard.partials.contacts')
            </div>

        </div>
    @endcan

@endsection

@include('backend.dashboard.modal.contact.showModal')
@include('backend.dashboard.partials.scripts')