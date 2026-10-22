@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('backend.measures') }}
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
                                    <h3 class="h5 text-black-50 m-0">Maßnahmen</h3>
                                </header>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="dropdown">
                                    <button class="btn btn-link btn-sm text-black text-decoration-none dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aktionen<i class="ms-2 fas fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a data-bs-toggle="modal" data-bs-target="#createMeasureModal" class="dropdown-item" href="{{ route('backend.measures.create') }}" data-ajax><i class="me-2 far fa-list" aria-hidden="true"></i>Maßnahme hinzufügen</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(!$measures->isEmpty())
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kampagne</th>
                                        <th>Anmeldungen</th>
                                        <th>Von</th>
                                        <th>Bis</th>
                                        <th>Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($measures as $measure)
                                        <tr>
                                            <td>{{ $measure->id }}</td>
                                            <td>{{ $measure->name }}</td>
                                            <td>{{ $measure->customerMeasures->count() }}</td>
                                            <td>{{ $measure->from->format('d.m.Y') }}</td>
                                            <td>{{ $measure->to->format('d.m.Y') }}</td>
                                            <td>
                                                <span class="btn-group btn-group-sm" role="group" aria-label="Funktionen zur Steuerung des Datensatzes">
                                                    <a data-bs-toggle="modal" data-bs-target="#showMeasuresModal" href="{{ route('backend.measures.{measure}.showModal', $measure) }}" data-ajax class="btn btn-secondary">Anzeigen</a>

                                                    <span class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-secondary px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="sr-only">Menü ein-/ausblenden</span><i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>

                                                        <ul class="dropdown-menu py-0">
                                                            <li><a href="{{ route('backend.measures.{measure}.edit', $measure) }}" class="dropdown-item"><i class="me-2 far fa-edit" aria-hidden="true"></i>Bearbeiten</a></li>
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
                                        Derzeit sind keine Maßnahmen verfügbar.
                                    </p>
                                </section>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        @if (!$measures->isEmpty())
                            <div class="row d-flex align-items-center py-2">
                                <div class="col-6">
                                    <span role="status" aria-live="polite">Zeige {{ $measures->firstItem() }} bis {{ $measures->lastItem() }} von {{ $measures->total() }} Ergebnissen</span>
                                </div>
                                <div class="col-6">
                                    <nav aria-label="Seitensteuerung für Tabelle">
                                        {{ $measures->appends(['per_page' => request('per_page', 25), 'filter' => request('filter'), 'sort' => request('sort'), 'search' => request('search')])->links() }}
                                    </nav>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="sticky-top sticky-top-offset">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body">
                                <h2 class="text-center">Sparkassen</h2>
                                <div style="width: 100%; height: 370px;" id="chartdiv_customer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('modal')

@include('backend.measures.partials.showModal')
@include('backend.measures.partials.createUpdateModal')

@endpush

@push('js')
    <script>
        var chart = am4core.create("chartdiv_customer", am4charts.PieChart);
        if (chart.logo) {
            chart.logo.disabled = true;
        }

        // Add data
        chart.data = [{
            "institut": "Sparkassen ohne Maßnahme " + {{ \Carbon\Carbon::now()->year }},
            "amount": '{{ $ínactiveMeasures }}',
            "color": am4core.color("#ffa500")
        }, {
            "institut": "Sparkasse mit Maßnahme " + {{ \Carbon\Carbon::now()->year }},
            "amount": '{{ $activeMeasures }}',
            "color": am4core.color("#ED1C24")
        }];

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.category = "institut";
        pieSeries.dataFields.value = "amount";
        pieSeries.slices.template.propertyFields.fill = "color";
        pieSeries.ticks.template.disabled = true;
        pieSeries.alignLabels = false;
        pieSeries.labels.template.text = "{amount}";
        pieSeries.labels.template.radius = am4core.percent(-40);
        pieSeries.legendSettings.labelText = "{category}";

        chart.legend = new am4charts.Legend();
        chart.legend.valueLabels.template.disabled = true;
    </script>
@endpush