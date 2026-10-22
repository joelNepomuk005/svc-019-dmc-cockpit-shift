<div class="row">
    <div class="col-12">
        <div class="row mb-3">
            <div class="col-6">
                <header>
                    <h3 class="h5">Budgetverwaltung</h3>
                </header>
            </div>
            @can('customer_budget_create')
            <div class="col-6">
                <a class="btn btn-secondary btn-sm btn-block waves-effect waves-light float-end" data-bs-toggle="modal" data-bs-target="#createBudgetModal" href="{{ route('backend.customers.{customer}.budgets.{type}.create', [$customer, 'budget']) }}" data-ajax>Budget erstellen</a>
            </div>
            @endcan
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-hover">
            @if(!empty($budgets))
                <thead>
                <tr>
                    <th>Betrag</th>
                    <th>Erfasser</th>
                    <th>Kampagne</th>
                    <th>Kommentar</th>
                    <th>Buchungsdatum</th>
                    <th>Aktionen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($budgets as $budget)
                    <tr>
                        <td>{{ $budget->budgetFormatted() }} €</td>
                        <td>{{ $budget->user->name }}</td>
                        <td>{{ $budget->measure->name }}</td>
                        <td>{{ $budget->note }}</td>
                        <td>{{ $budget->created_at->format('d.m.Y') }}</td>

                        <td>

                            <span class="btn-group btn-group-sm" role="group" aria-label="Funktionen zur Steuerung des Datensatzes">
                                <a data-bs-toggle="modal" data-bs-target="#showBudgetModal" href="{{ route('backend.customers.{customer}.budgets.{budget}.show', [$customer, $budget]) }}" data-ajax class="btn btn-secondary">Anzeigen</a>
                                 @can('customer_budget_edit')
                                <span class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-secondary px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Menü ein-/ausblenden</span><i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>

                                    <ul class="dropdown-menu py-0">
                                        <li><a data-bs-toggle="modal" data-bs-target="#createBudgetModal" data-ajax href="{{ route('backend.customers.{customer}.budgets.{budget}.{type}.editCustomer', [$customer, $budget, 'budget']) }}"  class="dropdown-item"><i class="me-2 far fa-edit" aria-hidden="true"></i>Bearbeiten</a></li>
                                        @can('customer_budget_delete')
                                        <li><a data-href="{{ route('backend.customers.{customer}.budgets.{budget}.destroy', [$customer, $budget]) }}" role="button" class="dropdown-item text-danger" data-ajax-method="DELETE" data-submit-dialog="true" data-dialog-header="Budget löschen" data-dialog-body="Bitte bestätigen Sie die Löschung des Budgets<br><b>„{{ $budget->amount }}“ €</b>"><i class="me-2 far fa-trash" aria-hidden="true"></i>Löschen</a></li>
                                        @endcan
                                    </ul>
                                </span>
                                @endcan
                            </span>
                        </td>
                    </tr>
                </tbody>
                @endforeach
                <tfoot>
                    <p><b>Gesamtbudget:</b> {{ $customer->sumPositiveBudgets() }} € <br> <b>Verfügbares Budget:</b> {{ $customer->sumBudgets() }} € <br> <b>Verbrauchtes Budget:</b> {{ str_replace('-', '', $customer->sumNegativeBudgets()) }} €</p>
                </tfoot>
            @else
                <div class="alert alert-info" role="alert">
                    <section>
                        <h4 class="alert-heading h5">Hinweis</h4>
                        <p>
                            Derzeit sind keine Budgets verfügbar.
                        </p>
                    </section>
                </div>
            @endif
        </table>
        @if(!$budgets->isEmpty())
            <div class="row d-flex align-items-center py-2">
                <div class="col-6">
                    <span role="status" aria-live="polite">Zeige {{ $budgets->firstItem() }} bis {{ $budgets->lastItem() }} von {{ $budgets->total() }} Ergebnissen</span>
                </div>
                <div class="col-6">
                    <nav aria-label="Seitensteuerung für Tabelle">
                        {{ $budgets->appends(['per_page' => request('per_page', 25), 'filter' => request('filter'), 'sort' => request('sort'), 'search' => request('search'), 'tab' => 'budgets'])->links() }}
                    </nav>
                </div>
            </div>
        @endif
    </div>
</div>
@include('backend.customers.partials.modal.budget.showModal')
@include('backend.customers.partials.modal.budget.createUpdateModal')