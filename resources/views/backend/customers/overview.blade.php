@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('backend.customers') }}
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
                                    <h3 class="h5 text-black-50 m-0">Sparkassen</h3>
                                </header>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="dropdown">
                                    <button class="btn btn-link btn-sm text-black text-decoration-none dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aktionen<i class="ms-2 fas fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a id="exportCustomerExcel" href="{{ route('backend.reports.excel_export_customers') }}" class="dropdown-item"><i class="me-2 far fa-list" aria-hidden="true"></i>Excel-Datei exportieren</a></li>
                                        @can('customer_import')
                                        <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#uploadModal"><i class="me-2 far fa-list" aria-hidden="true"></i>Sparkassen importieren</a></li>
                                        @endcan
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(!$customers->isEmpty())
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Sparkasse</th>
                                    <th>Verband</th>
                                    <th>BLZ</th>
                                    <th>Gesamtbudget</th>
                                    <th>Verfügbares Budget</th>
                                    <th>Verbrauchtes Budget</th>
                                    <th>Status</th>
                                    <th>Aktion</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td><a href="{{ route('backend.customers.{customer}.show', $customer) }}">{{ $customer->name }}</a></td>
                                        <td>{{ $customer->association->short_name }}</td>
                                        <td>{{$customer->blz}}</td>
                                        <td>{{ $customer->sumPositiveBudgets() }} €</td>
                                        <td><span class="text-success">{{ $customer->sumBudgets() }} €</span></td>
                                        <td>{{ str_replace('-', '', $customer->sumNegativeBudgets()) }} €</td>
                                        <td>
                                            @if ($customer->deleted_at)
                                                <span class="text-danger">Archiviert</span>
                                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Archiviert am <?php echo ($customer->deleted_at->format('d.m.Y')); ?>"><i class="fas fa-circle-info ms-1"></i></span>
                                            @else
                                                <span class="text-success">Aktiv</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @if($customer->deleted_at)
                                                <span class="btn-group btn-group-sm" role="group" aria-label="Funktionen zur Steuerung des Datensatzes" style="float: right; background-color: #f2f2f2; opacity: 0.7; pointer-events: none;">
                                                    <a type="button" href="{{ route('backend.customers.{customer}.show', $customer) }}" class="btn btn-secondary">Anzeigen</a>
                                                    <span class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-secondary px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="sr-only">Menü ein-/ausblenden</span><i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu py-0">
                                                            <li><a href="#" class="dropdown-item" disabled><i class="far fa-eye"></i> Anzeigen</a></li>
                                                            <li><a href="#" class="dropdown-item" disabled><i class="far fa-edit"></i> Bearbeiten</a></li>
                                                            <li>
                                                                <form action="#" method="POST" id="delete-form-{{ $customer }}" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                                <a href="#" class="dropdown-item border-top" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $customer }}').submit();" disabled><i class="far fa-trash-alt"></i> Archivieren</a>
                                                            </li>
                                                        </ul>
                                                    </span>
                                                </span>
                                                @else
                                                <span class="btn-group btn-group-sm" role="group" aria-label="Funktionen zur Steuerung des Datensatzes" style="float: right;">
                                                    <a type="button" href="{{ route('backend.customers.{customer}.show', $customer) }}" class="btn btn-secondary"> Anzeigen</a>
                                                    <span class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-secondary px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="sr-only">Menü ein-/ausblenden</span><i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu py-0">
                                                            <li><a href="{{ route('backend.customers.{customer}.show', $customer) }}" class="dropdown-item"><i class="far fa-eye"></i> Anzeigen</a></li>
                                                            <li><a href="{{ route('backend.customers.{customer}.edit', $customer) }}" class="dropdown-item"><i class="far fa-edit"></i> Bearbeiten</a></li>
                                                            <li>
                                                                <form action="{{ route('backend.customers.{customer}.delete', $customer) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="dropdown-item border-top" type="submit"><i class="far fa-trash-alt"></i> Archivieren</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </span>
                                                </span>
                                            @endif
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
                                        Derzeit sind keine Sparkassen verfügbar.
                                    </p>
                                </section>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
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

            <div class="col-3">
                <div class="sticky-top sticky-top-offset">
                    <div class="filter">
                        <form id="filter" method="GET" action="{{ route('backend.customers.index') }}" name="filter" enctype="multipart/form-data">
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
                                                <label for="filter_customSearch">Institutsname, Kurzname oder BLZ</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="filter[association_id]" id="filter_association_id">
                                                    <option value="" selected>Alle</option>
                                                    @foreach(\App\Models\CustomerAssociation::all() as $customer_association)
                                                        <option value="{{ $customer_association->id }}" {{ old('filter.association_id', request('filter.association_id')) == $customer_association->id ? 'selected' : '' }}>{{ $customer_association->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="filter_association_id" class="active">Verband</label>
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
                                            <a href="{{ route('backend.customers.index') }}" class="btn btn-link btn-sm d-block w-100 text-black-50 text-decoration-none" name="filter-reset"><i class="fas fa-times me-2" aria-hidden="true"></i><span class="d-xs-none">Filter zurücksetzen</span></a>
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
@push('js')
    <script>
        $(document).ready(function(){

            $('.table-sm tr:last').attr('style', 'border-bottom-style: hidden');

            $('#exportCustomerExcel').on('click', function () {
                event.preventDefault();
                window.location = $(this).attr('href') + '?' + $('#filter').serialize();
            })

        });
    </script>
@endpush
@push('modal')
    <div id="uploadModal" class="modal fade" aria-labelledby="uploadModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('backend.customers.upload') }}" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Import</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <aside>
                                <p>
                                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                                </p>
                            </aside>
                        </div>
                        <div class="mb-3">
                            <label for="upload" class="form-label">Datei</label>
                            <input type="file" id="upload" name="upload" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-link" data-bs-dismiss="modal">Schließen</button>
                        <button type="submit" class="btn btn-sm btn-primary text-white">Hochladen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush

