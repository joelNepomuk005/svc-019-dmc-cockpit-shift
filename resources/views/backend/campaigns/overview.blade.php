@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('backend.campaigns') }}
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <!-- -------- Table -->

            <div class="col-9">
                <div class="card">
                    <div class="card-header bg-accent py-3">
                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-grow-1 justify-content-start">
                                <header>
                                    <h3 class="h5 text-black-50 m-0">Wettbewerbe</h3>
                                </header>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="dropdown">
                                    <button class="btn btn-link btn-sm text-black text-decoration-none dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aktionen<i class="ms-2 fas fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a data-bs-toggle="modal" data-bs-target="#createCampaignModal" class="dropdown-item" href="{{ route('backend.campaigns.create') }}" data-ajax><i class="me-2 far fa-list" aria-hidden="true"></i>Wettbewerb hinzufügen</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(is_countable($campaigns) && count($campaigns) > 0)
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Wettbewerb</th>
                                        <th>Von</th>
                                        <th>Bis</th>
                                        <th></th>
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($campaigns as $campaign)
                                        <tr>
                                            <td>{{ $campaign->id }}</td>
                                            <td>{{ $campaign->name }}</td>
                                            <td>{{ $campaign->start_date->format('d.m.Y') }}</td>
                                            <td>{{ $campaign->end_date->format('d.m.Y') }}</td>
                                            <td></td>
                                            <td>
                                                <span class="btn-group btn-group-sm" role="group" aria-label="Funktionen zur Steuerung des Datensatzes">
                                                   <a href="{{ route('backend.campaigns.{campaign}.edit', $campaign) }}" class="btn btn-secondary">Bearbeiten</a>
                                                    <span class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-secondary px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="sr-only">Menü ein-/ausblenden</span><i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>

                                                        <ul class="dropdown-menu py-0">
                                                            <li><a data-href="{{ route('backend.campaigns.{campaign}.destroy', $campaign) }}" role="button" class="dropdown-item text-danger" data-ajax-method="DELETE" data-submit-dialog="true" data-dialog-header="Wettbewerb löschen" data-dialog-body="Bitte bestätigen Sie die Löschung des Wettbewerbs<br><b>„{{ $campaign->name }}“ €</b>"><i class="me-2 far fa-trash" aria-hidden="true"></i>Löschen</a></li>
                                                        </ul>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info" role="alert">
                                <section>
                                    <h4 class="alert-heading h5">Hinweis</h4>
                                    <p>
                                        Derzeit sind keine Wettbewerbe verfügbar.
                                    </p>
                                </section>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        @if (is_countable($camapigns) && count($camapigns) > 0)
                            <div class="row d-flex align-items-center py-2">
                                <div class="col-6">
                                    <span role="status" aria-live="polite">Zeige {{ $campaigns->firstItem() }} bis {{ $campaigns->lastItem() }} von {{ $campaigns->total() }} Ergebnissen</span>
                                </div>
                                <div class="col-6">
                                    <nav aria-label="Seitensteuerung für Tabelle">
                                        {{ $campaigns->appends(['per_page' => request('per_page', 25), 'filter' => request('filter'), 'sort' => request('sort'), 'search' => request('search')])->links() }}
                                    </nav>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="sticky-top sticky-top-offset">
                    <div class="filter">
                        <form id="filter" method="GET" action="{{ route('backend.campaigns.index') }}" name="filter" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header bg-accent py-3">
                                    <h6 class="h5 text-black-50 mb-0">Filter</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="filter[customSearch]" id="filter_customSearch" placeholder="Name oder ID" value="{{ old('filter.customSearch', request("filter.customSearch"))  }}" autocomplete="off" class="form-control">
                                                <label for="filter_customSearch">Wettbewerbname oder ID</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-accent">
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="per_page" id="per_page">
                                                    <option value="" readonly disabled>Ergebnisse je Seite</option>
                                                    <option value="25" {{ request('per_page', 25)  == 25 ? 'selected' : null }}>25 Ergebnisse je Seite</option>
                                                    <option value="50" {{ request('per_page')  == 50 ? 'selected' : null }}>50 Ergebnisse je Seite</option>
                                                    <option value="100" {{ request('per_page')  == 100 ? 'selected' : null }}>100 Ergebnisse je Seite</option>
                                                    <option value="100000" {{ request('per_page') == 100000 ? 'selected' : null }}>Alle</option>
                                                </select>
                                                <label for="per_page" class="active">Ergebnisse je Seite</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <select class="form-select" name="sort" id="sort">
                                                    <option value="" readonly disabled>Sortierung</option>
                                                    <option value="name" {{ old('sort', request('sort')) == 'name' ? 'selected' : null }}>Institutsname aufsteigend</option>
                                                    <option value="-name" {{ old('sort', request('sort')) == '-name' ? 'selected' : null }}>Institutsname absteigend</option>
                                                    <option value="blz" {{ old('sort', request('sort')) == 'blz' ? 'selected' : null }}>BLZ aufsteigend</option>
                                                    <option value="-blz" {{ old('sort', request('sort')) == '-blz' ? 'selected' : null }}>BLZ absteigend</option>
                                                    <option value="customBudget" {{ old('sort', request('sort')) == 'customBudget' ? 'selected' : null }}>Gesamtbudget aufsteigend</option>
                                                    <option value="-customBudget" {{ old('sort', request('sort')) == '-customBudget' ? 'selected' : null }}>Gesamtbudget absteigend</option>
                                                </select>
                                                <label for="sort" class="active">Sortierung</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-2">
                                        <div class="col-6">
                                            <button class="btn btn-secondary btn-sm d-block w-100 waves-effect waves-light" name="filter-submit" type="submit"><i class="fas fa-filter me-2" aria-hidden="true"></i><span class="d-xs-none">Filter anwenden</span></button>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('backend.campaigns.index') }}" class="btn btn-link btn-sm d-block w-100 text-black-50 text-decoration-none" name="filter-reset"><i class="fas fa-times me-2" aria-hidden="true"></i><span class="d-xs-none">Filter zurücksetzen</span></a>
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
@endsection
@push('modal')

@include('backend.campaigns.partials.createUpdateModal')

@endpush
