<div class="row">
    <div class="col-12">
        <div class="row mb-3">
            <div class="col-6">
                <header>
                    <h3 class="h5">Kontakte</h3>
                </header>
            </div>
            <div class="col-6">
                <a class="btn btn-secondary btn-sm btn-block waves-effect waves-light float-end" data-bs-toggle="modal" data-bs-target="#createContactModal" href="{{ route('backend.customers.{customer}.contact.create', $customer) }}" data-ajax>Kontakt erstellen</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-hover">
            @if(!$customerContacts->isEmpty())
            <thead>
                <tr>
                    <th>#</th>
                    <th>Datum</th>
                    <th>Erfasser</th>
                    <th>Betreff</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
            @foreach($customerContacts as $customerContact)
                <tr>
                    <td>{{ $customerContact->id }}</td>
                    <td>{{ $customerContact->date->format('d.m.Y') }}</td>
                    <td>{{ $customerContact->user->name }}</td>
                    <td>{{ $customerContact->title }}</td>
                    <td>
                        <span class="btn-group btn-group-sm" role="group" aria-label="Funktionen zur Steuerung des Datensatzes">
                            <a data-bs-toggle="modal" data-bs-target="#showContactModal" href="{{ route('backend.contacts.{customerContact}.show', $customerContact) }}" data-ajax class="btn btn-secondary">Anzeigen</a>
                            <span class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-secondary px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Menü ein-/ausblenden</span><i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                                </button>

                                <ul class="dropdown-menu py-0">
                                    <li><a data-bs-toggle="modal" data-bs-target="#createContactModal" data-ajax href="{{ route('backend.customers.{customer}.contact.{customerContact}.edit', [$customer, $customerContact]) }}"  class="dropdown-item"><i class="me-2 far fa-edit" aria-hidden="true"></i>Bearbeiten</a></li>
                                    <li><a data-href="{{ route('backend.customers.{customer}.contact.{customerContact}.destroy', [$customer, $customerContact]) }}" role="button" class="dropdown-item text-danger" data-ajax-method="DELETE" data-submit-dialog="true" data-dialog-header="Kontakt löschen" data-dialog-body="Bitte bestätigen Sie die Löschung des Kontaktes<br><b>„{{ $customerContact->user->name }}“</b>"><i class="me-2 far fa-trash" aria-hidden="true"></i>Löschen</a></li>
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
                            Derzeit sind keine Kontakte verfügbar.
                        </p>
                    </section>
                </div>
            @endif
        </table>
        @if(!$customerContacts->isEmpty())
            <div class="row d-flex align-items-center py-2">
                <div class="col-6">
                    <span role="status" aria-live="polite">Zeige {{ $customerContacts->firstItem() }} bis {{ $customerContacts->lastItem() }} von {{ $customerContacts->total() }} Ergebnissen</span>
                </div>
                <div class="col-6">
                    <nav aria-label="Seitensteuerung für Tabelle">
                        {{ $customerContacts->appends(['per_page' => request('per_page', 25), 'filter' => request('filter'), 'sort' => request('sort'), 'search' => request('search'), 'tab' => 'contacts'])->links() }}
                    </nav>
                </div>
            </div>
        @endif
    </div>
</div>
@include('backend.customers.partials.modal.contact.showModal')
@include('backend.customers.partials.modal.contact.createUpdateModal')