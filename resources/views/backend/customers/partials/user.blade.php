<div class="row">
    <div class="col-12">
        <div class="row mb-3">
            <div class="col-6">
                <header>
                    <h3 class="h5">Personen</h3>
                </header>
            </div>
            <div class="col-6">
                <a class="btn btn-secondary btn-sm btn-block waves-effect waves-light float-end" data-bs-toggle="modal" data-bs-target="#createUserModal" href="{{ route('backend.customers.{customer}.users.create', $customer) }}" data-ajax>Person erstellen</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-hover">
            @if(!$customerUsers->isEmpty())
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Vorname</th>
                    <th>Anrede</th>
                    <th>Position</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Aktionen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customerUsers as $customerUser)
                    <tr>
                        <td>{{ $customerUser->id }}</td>
                        <td>{{ $customerUser->last_name }}</td>
                        <td>{{ $customerUser->first_name }}</td>
                        <td>
                            @if ($customerUser->salutation == 'male')
                                Herr
                            @elseif($customerUser->salutation == 'female')
                                Frau
                            @else
                                Divers
                            @endif
                        </td>
                        <td>{{ $customerUser->userCategories->name }}</td>
                        <td>{{ $customerUser->email }}</td>
                        <td>{{ $customerUser->phone }}</td>
                        <td>
                        <span class="btn-group btn-group-sm" role="group" aria-label="Funktionen zur Steuerung des Datensatzes">
                            <a data-bs-toggle="modal" data-bs-target="#showUserModal" href="{{ route('backend.users.{user}.show', $customerUser) }}" data-ajax class="btn btn-secondary">Anzeigen</a>
                            <span class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-secondary px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Menü ein-/ausblenden</span><i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                                </button>

                                <ul class="dropdown-menu py-0">
                                   <li><a data-bs-toggle="modal" data-bs-target="#createUserModal" href="{{ route('backend.customers.{customer}.users.{user}.editCustomer', [$customer, $customerUser]) }}" data-ajax class="dropdown-item"><i class="me-2 far fa-edit" aria-hidden="true"></i>Bearbeiten</a></li>
                                    <li><a data-href="{{ route('backend.users.{user}.destroy', $customerUser) }}" role="button" class="dropdown-item text-danger" data-ajax-method="DELETE" data-submit-dialog="true" data-dialog-header="Person löschen" data-dialog-body="Bitte bestätigen Sie die Löschung der Person <br><b>„{{ $customerUser->first_name . ' ' . $customerUser->last_name }}“</b>"><i class="me-2 far fa-trash" aria-hidden="true"></i>Löschen</a></li>
                                </ul>
                            </span>
                        </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @else
                <div class="alert alert-info" role="alert">
                    <section>
                        <h4 class="alert-heading h5">Hinweis</h4>
                        <p>
                            Derzeit sind keine Personen verfügbar.
                        </p>
                    </section>
                </div>
            @endif
        </table>
        @if(!$customerUsers->isEmpty())
            <div class="row d-flex align-items-center py-2">
                <div class="col-6">
                    <span role="status" aria-live="polite">Zeige {{ $customerUsers->firstItem() }} bis {{ $customerUsers->lastItem() }} von {{ $customerUsers->total() }} Ergebnissen</span>
                </div>
                <div class="col-6">
                    <nav aria-label="Seitensteuerung für Tabelle">
                        {{ $customerUsers->appends(['per_page' => request('per_page', 25), 'filter' => request('filter'), 'sort' => request('sort'), 'search' => request('search'), 'tab' => 'users'])->links() }}
                    </nav>
                </div>
            </div>
        @endif
    </div>
</div>
@include('backend.customers.partials.modal.user.showModal')
@include('backend.customers.partials.modal.user.createUpdateModal')