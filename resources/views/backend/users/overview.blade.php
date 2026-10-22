@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('backend.users') }}
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
                                    <h3 class="h5 text-black-50 m-0">Personen</h3>
                                </header>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="dropdown">
                                    <button class="btn btn-link btn-sm text-black text-decoration-none dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aktionen<i class="ms-2 fas fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a data-bs-toggle="modal" data-bs-target="#createUserModal" class="dropdown-item" href="{{ route('backend.users.create') }}" data-ajax><i class="me-2 far fa-list" aria-hidden="true"></i>Person erstellen</a></li>
                                        <li><a id="exportUserExcel" href="{{ route('backend.reports.user_export_excel') }}" class="dropdown-item"><i class="me-2 far fa-file-excel" aria-hidden="true"></i>Personen Exportieren</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(!$users->isEmpty())
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>S-Cockpit User</th>
                                    <th>Anrede</th>
                                    <th>Name</th>
                                    <th>Vorname</th>
                                    <th>Position</th>
                                    <th>E-Mail</th>
                                    <th>Telefonnummer</th>
                                    <th>Sparkasse</th>
                                    <th>Freigegeben</th>
                                    <th>Aktionen</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>@if (!empty($user->scockpit_user_id)) <span><i class="fa fa-check text-success"></i></span> @else <span><i class="fa fa-times text-danger"></i></span> @endif </td>
                                        <td>@if ($user->sex == 'male') Herr @elseif ($user->salutation == 'female') Frau @endif</td>
                                        <td>{{ $user->last_name }}</a></td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->userCategories->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->customer->name }}</td>
                                        <td>@if (!is_null($user->verified_at)) <span><i class="fa fa-check text-success"></i></span> @else <span><i class="fa fa-times text-danger"></i></span> @endif </td>
                                        <td>
                                                 <span class="btn-group btn-group-sm" role="group" aria-label="Funktionen zur Steuerung des Datensatzes">
                                                     <a data-bs-toggle="modal" data-bs-target="#showUserModal" href="{{ route('backend.users.{user}.show', $user) }}" data-ajax class="btn btn-secondary">Anzeigen</a>

                                                     <span class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-secondary px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="sr-only">Menü ein-/ausblenden</span><i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>

                                                         <ul class="dropdown-menu py-0">
                                                             <li>
                                                                 <a data-bs-toggle="modal" data-bs-target="#createUserModal" href="{{ route('backend.users.{user}.edit', $user) }}" data-ajax class="dropdown-item"><i class="me-2 far fa-edit" aria-hidden="true"></i>Bearbeiten</a>
                                                             </li>
                                                             @can('user_impersonate')
                                                                 @if($user->id != auth()->id())
                                                                     <li><a href="{{ route('backend.users.{user}.impersonate', $user) }}" class="dropdown-item"><i class="me-2 far fa-user" aria-hidden="true"></i>Sitzung übernehmen</a></li>
                                                                 @else
                                                                     <li><a href="#" class="dropdown-item disabled"><i class="me-2 far fa-user" aria-hidden="true"></i>Sitzung übernehmen</a></li>
                                                                 @endif
                                                             @endcan
                                                             @can('user_release')
                                                                 <li>
                                                                 <a href="{{ route('backend.users.{user}.release', $user) }}" class="dropdown-item {{!is_null($user->verified_at) ? 'disabled' : ''}}"><i class="me-2 far fa-check" aria-hidden="true"></i>Benutzer freigeben</a>
                                                             </li>
                                                             @endcan
                                                             @can('user_delete')
                                                                 <li>
                                                                    <a data-href="{{ route('backend.users.{user}.destroy', $user) }}" role="button" class="dropdown-item text-danger" data-ajax-method="DELETE" data-submit-dialog="true" data-dialog-header="Benutzer löschen" data-dialog-body="Bitte bestätigen Sie die Löschung des Benutzers<br><b>„{{ $user->name }}“</b>"><i class="me-2 far fa-trash" aria-hidden="true"></i>Benutzer Löschen</a>
                                                                </li>
                                                             @endcan
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
                                        Derzeit sind keine Ansprechpartner ensehbar.
                                    </p>
                                </section>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        @if (!$users->isEmpty())
                            <div class="row d-flex align-items-center py-2">
                                <div class="col-6">
                                    <span role="status" aria-live="polite">Zeige {{ $users->firstItem() }} bis {{ $users->lastItem() }} von {{ $users->total() }} Ergebnissen</span>
                                </div>
                                <div class="col-6">
                                    <nav aria-label="Seitensteuerung für Tabelle">
                                        {{ $users->appends(['per_page' => request('per_page', 25), 'filter' => request('filter'), 'sort' => request('sort'), 'search' => request('search')])->links() }}
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
                        <form id="filter" name="filter" method="get" action="{{ route('backend.users.index') }}">
                            @csrf
                            <div class="card">
                                <div class="card-header bg-accent py-3">
                                    <h6 class="h5 text-black-50 mb-0">Filter</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input type="text" name="filter[customSearch]" id="filter_customSearch" placeholder="Name oder ID" value="{{ old('filter.customSearch', request("filter.customSearch")) }}" autocomplete="off" class="form-control">
                                                <label for="filter_customSearch">ID, Name</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" role="switch" name="filter[scockpit_user_id]" id="filter_scockpit_user_id" {{ old('filter.scockpit_user_id', request("filter.scockpit_user_id")) == 1 ? 'checked' : '' }} value="1" class="form-check-input">
                                                <label for="scockpit_user_id" class="form-check-label">S-Cockpit Benutzer</label>
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
                                                </select>
                                                <label for="per_page" class="active">Ergebnisse je Seite</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <select class="form-select" name="sort" id="sort">
                                                    <option value="" readonly disabled>Sortierung</option>
                                                    <option value="id" {{ old('sort', request('sort')) == 'id' ? 'selected' : null }}>ID aufsteigend</option>
                                                    <option value="-id" {{ old('sort', request('sort')) == '-id' ? 'selected' : null }}>ID absteigend</option>
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
                                            <a href="{{ route('backend.users.index') }}" class="btn btn-link btn-sm d-block w-100 text-black-50 text-decoration-none" name="filter-reset"><i class="fas fa-times me-2" aria-hidden="true"></i><span class="d-xs-none">Filter zurücksetzen</span></a>
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

@include('backend.users.partials.showModal')
@include('backend.users.partials.createUpdateModal')
@push('js')
    <script>
        $(document).ready(function(){

            $('#exportUserExcel').on('click', function () {
                event.preventDefault();
                window.location = $(this).attr('href') + '?' + $('#filter').serialize();
            })

        });
    </script>
@endpush
