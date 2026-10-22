@can('home_dashboard_customers')
    <div class="col-sm-12 flex-col-custom-1 col-md-6 mb-3">
        <div class="card shadow">
            <div class="card-header p-3">
                <header>
                    <h3 class="h5 text-black-50 m-0">Sparkassen verwalten</h3>
                </header>
            </div>
            <div class="card-body">
                <section>
                    @if (is_countable($customers) && $customers->count() > 0)
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Sparkasse</th>
                                <th>BLZ</th>
                                <th>Gesamtbudget</th>
                                <th>Verfügbares Budget</th>
                                <th>Verbrauchtes Budget</th>
                            </tr>
                            </thead>
                            <tbody id="customers_table">
                            @foreach($customers as $customer)
                                <tr>
                                    <td><a class="no-wrap" href="{{ route('backend.customers.{customer}.show', $customer) }}">{{ $customer->name }}</a></td>
                                    <td>{{ $customer->blz }}</td>
                                    <td>{{ $customer->sumPositiveBudgets() }} €</td>
                                    <td><p class="text-success">{{ $customer->sumBudgets() }} €</p></td>
                                    <td>{{ $customer->sumNegativeBudgets() }} €</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row d-flex align-items-center py-2 pt-3">
                            <div class="col-12">
                                @if (!$customers->isEmpty())
                                    <div class="row d-flex align-items-center py-2">
                                        <div class="col-12">
                                            <span role="status" aria-live="polite">Zeige {{ $customers->firstItem() }} bis {{ $customers->lastItem() }} von {{ $customers->total() }} Ergebnissen</span>
                                        </div>
                                        <div class="col-12">
                                            <nav aria-label="Seitensteuerung für Tabelle">
                                                {{ $customers->appends(['per_page' => request('per_page', 10), 'filter' => request('filter'), 'sort' => request('sort'), 'search' => request('search')])->links() }}
                                            </nav>
                                        </div>
                                    </div>
                                @endif
                                <nav aria-label="Seitensteuerung für Tabelle">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="{{ route('backend.customers.index') }}" class="btn btn-secondary btn-sm d-block w-100 waves-effect waves-light" type="submit"><i class="fas fa-filter me-2" aria-hidden="true"></i>Alle anzeigen</a>
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
                                    Derzeit sind keine Sparkassen verfügbar.
                                </p>
                            </section>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
@endcan