<div class="row">
    <div class="col-12">
        <div class="row mb-3">
            <div class="col-6">
                <header>
                    <h3 class="h5">Maßnahmen</h3>
                </header>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-hover">
            @if(!empty($measures))
                <thead>
                <tr>
                    <th>Kampagne</th>
                    <th>Status</th>
                    <th>anmeldende Person</th>
                    <th>Datum</th>
                    <th>Anmelden</th>
                    <th>Aktion</th>
                </tr>
                </thead>
                <tbody>
                @foreach($measures as $measure)
                    <tr>
                        <td> <a data-bs-toggle="modal" data-bs-target="#showMeasuresModal" href="{{ route('backend.customers.{customer}.measures.{measure}.showModalCustomer', [$customer, $measure]) }}" data-ajax >{{ $measure->name }}</a></td>
                        <td>{!! $measure->getBadgeInformation($customer->id) !!}</td>
                        <td>
                            @if(!empty($measure->customerMeasure($customer->id)))
                                {{$measure->customerMeasure($customer->id)->causer()->name}}
                            @endif
                        </td>
                        <td>{{ $measure->from->format('d.m.Y') . ' - ' . $measure->to->format('d.m.Y') }}</td>
                        @if($measure->getMeasureState($customer->id) == 'offen')
                        <td><a  data-bs-toggle="modal" data-bs-target="#createMeasureModal" href="{{ route('backend.customers.{customer}.measures.{measure}.editCustomer', [$customer, $measure]) }}" data-ajax class="btn btn-primary btn-sm">Maßnahme buchen</a></td>
                        @else
                            <td><a  data-bs-toggle="modal" data-bs-target="#createMeasureModal"  data-ajax class="btn btn-primary btn-sm disabled">Maßnahme buchen</a></td>
                        @endif
                        <td>
                            <span class="btn-group btn-group-sm" role="group" aria-label="Funktionen zur Steuerung des Datensatzes">
                                 <a data-bs-toggle="modal" data-bs-target="#showMeasuresModal" href="{{ route('backend.customers.{customer}.measures.{measure}.showModalCustomer', [$customer, $measure]) }}" data-ajax class="btn btn-secondary">Anzeigen</a>
                            </span>
                        </td>
                    </tr>
                </tbody>
                @endforeach
            @else
                <div class="alert alert-info" role="alert">
                    <section>
                        <h4 class="alert-heading h5">Hinweis</h4>
                        <p>
                            Derzeit sind keine Maßnahmen verfügbar.
                        </p>
                    </section>
                </div>
            @endif
        </table>
        @if(!$measures->isEmpty())
            <div class="row d-flex align-items-center py-2">
                <div class="col-6">
                    <span role="status" aria-live="polite">Zeige {{ $measures->firstItem() }} bis {{ $measures->lastItem() }} von {{ $measures->total() }} Ergebnissen</span>
                </div>
                <div class="col-6">
                    <nav aria-label="Seitensteuerung für Tabelle">
                        {{ $measures->appends(['per_page' => request('per_page', 25), 'filter' => request('filter'), 'sort' => request('sort'), 'search' => request('search'), 'tab' => 'measures'])->links() }}
                    </nav>
                </div>
            </div>
        @endif
    </div>
</div>
@include('backend.customers.partials.modal.measure.showModal')
@include('backend.customers.partials.modal.measure.createUpdateModal')
