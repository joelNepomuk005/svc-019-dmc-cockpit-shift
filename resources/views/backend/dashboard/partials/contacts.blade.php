@can('home_dashboard_contacts')
    <div class="col-sm-12 flex-col-custom-2 col-md-6 mb-3">
        <div class="card shadow h-100">
            <div class="card-header p-3">
                <header>
                    <h3 class="h5 text-black-50 m-0">Kontakte / Termine</h3>
                </header>
            </div>
            <div class="card-body">
                <section>
                    @if (is_countable($customerContacts) && $customerContacts->count() > 0)
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Sparkasse</th>
                                <th>Erfasser</th>
                                <th>Betreff</th>
                            </tr>
                            </thead>
                            <tbody id="contacts_table">
                            @foreach($customerContacts as $customerContact)
                                <tr>
                                    <td><a href="{{ route('backend.customers.{customer}.show', $customerContact->customer) }}">{{ $customerContact->customer->name }}</a></td>
                                    <td>{{ $customerContact->user->name }}</td>
                                    <td>{{ $customerContact->title }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row d-flex align-items-center py-2 pt-3">
                            <div class="col-12">
                                @if (!$customerContacts->isEmpty())
                                    <div class="row d-flex align-items-center py-2">
                                        <div class="col-12">
                                            <span role="status" aria-live="polite">Zeige {{ $customerContacts->firstItem() }} bis {{ $customerContacts->lastItem() }} von {{ $customerContacts->total() }} Ergebnissen</span>
                                        </div>
                                        <div class="col-12">
                                            <nav aria-label="Seitensteuerung für Tabelle">
                                                {{ $customerContacts->appends(['per_page' => request('per_page', 10), 'filter' => request('filter'), 'sort' => request('sort'), 'search' => request('search')])->links() }}
                                            </nav>
                                        </div>
                                    </div>
                                @endif
                                <nav aria-label="Seitensteuerung für Tabelle">
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{ route('backend.contacts.index') }}" class="btn btn-secondary btn-sm d-block w-100 waves-effect waves-light" type="submit"><i class="fas fa-filter me-2" aria-hidden="true"></i>Alle anzeigen</a>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>

                    @else
                        <div class="alert alert-info" role="alert">
                            <section>
                                <h4 class="alert-heading h5">Hinweis</h4>
                                <p>
                                    Derzeit sind keine Kontakte / Termine verfügbar.
                                </p>
                            </section>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
@endcan