@can('home_dashboard_measures')
    <div class="col-sm-12 col-md-8 mb-3">
        <div class="card shadow">
            <div class="card-header p-3">
                <header>
                    <h3 class="h5 text-black-50 m-0">Maßnahmen verwalten</h3>
                </header>
            </div>
            <div class="card-body">
                @if (is_countable($measures) && $measures->count() > 0)
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                        <tr>
                            <th>Maßnahme</th>
                            <th>Datum</th>
                            <th>Ihr gebuchter Zeitraum</th>
                            <th>Status</th>
                            <th>Anmelden</th>
                        </tr>
                        </thead>
                        <tbody id="measures_table">

                        @foreach($measures as $measure)

                            <tr>
                                <td><a href="{{ !empty(\Illuminate\Support\Facades\Auth::user()->customer) ? route('backend.customers.{customer}.modalTabs', [Auth::user()->customer, 'measures']) : '' }}">{{ $measure->name }}</a></td>
                                <td>{{ $measure->from->format('d.m.y').' - '.  $measure->to->format('d.m.y') }}</td>

                                @php
                                    $customerMeasure = $measure->customerMeasure(\Illuminate\Support\Facades\Auth::user()->customer->id);
                                @endphp

                                <td>@if($customerMeasure) {{ $customerMeasure->from->format('d.m.Y') }} - {{  $customerMeasure->to->format('d.m.Y') }} @else - @endif</td>
                                <td>{!!  $measure->getBadgeInformation(Auth::user()->customer->id)  !!}</td>
                                @if($measure->getMeasureState(Auth::user()->customer->id) == 'offen')
                                    <td><a href="{{ route('backend.measures.{measure}.showMeasure', $measure) }}" class="btn btn-primary btn-sm">Maßnahme anmelden</a></td>
                                @else
                                    <td>
                                        <span class="btn-group btn-group-sm" role="group" aria-label="Funktionen zur Steuerung des Datensatzes">
                                            <a type="button" href="{{ route('backend.measures.{measure}.showMeasure', $measure) }}"class="btn btn-secondary">Maßnahme Anzeigen</a>
                                        </span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row d-flex align-items-center py-2 pt-3">
                        <div class="col-12">
                            @if (!$measures->isEmpty())
                                <div class="row d-flex align-items-center py-2">
                                    <div class="col-12">
                                        <span role="status" aria-live="polite">Zeige {{ $measures->firstItem() }} bis {{ $measures->lastItem() }} von {{ $measures->total() }} Ergebnissen</span>
                                    </div>
                                    <div class="col-12">
                                        <nav aria-label="Seitensteuerung für Tabelle">
                                            {{ $measures->appends(['per_page' => request('per_page', 10), 'filter' => request('filter'), 'sort' => request('sort'), 'search' => request('search')])->links() }}
                                        </nav>
                                    </div>
                                </div>
                            @endif
                            <nav aria-label="Seitensteuerung für Tabelle">
                                <div class="row">
                                    <div class="col-md-12">
                                        @can('home_dashboard_measures_customer')
                                            <a  href="{{ route('backend.customers.{customer}.modalTabs', [Auth::user()->customer, 'measures']) }}" class="btn btn-secondary btn-sm d-block w-100 waves-effect waves-light" type="submit"><i class="fas fa-filter me-2" aria-hidden="true"></i>Maßnahmen verwalten</a>
                                        @endcan
                                        @can('home_dashboard_measures_all_customer')
                                            <a href="{{ route('backend.measures.index') }}" class="btn btn-secondary btn-sm d-block w-100 waves-effect waves-light" type="submit"><i class="fas fa-filter me-2" aria-hidden="true"></i>Maßnahmen verwalten</a>
                                        @endcan

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
                                Derzeit sind keine Maßnahmen verfügbar.
                            </p>
                        </section>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endcan
