<div class="row">
    <div class="col-12">
        <div class="row mb-3">
            <div class="col-6">
                <header>
                    <h3 class="h5">Maßnahme</h3>
                </header>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-6 mb-5">
        <h2 class="h2">{{$measure->name}} <small>({{$measure->from->format('d.m.y') .' - '.$measure->to->format('d.m.y')}})</small></h2>
        <span class="mb-5">Status: {!! $measure->getBadgeInformation(Auth::user()->customer->id)  !!}</span>
        <p>
            Die Anlage Datenschutz zur Auftragsverarbeitung zum Angebot „DMC Aktivierungs-Kampagnen“ finden Sie <a href="{{ asset('media/document/20250403_AVA_DMC_Aktivierungs-Kampagnen.pdf') }}" target="_blank">hier</a>.<br>
            Die Anlage ergänzt den zwischen der S-Markt & Mehrwert und der Sparkasse vereinbarten Auftragsverarbeitungsvertrag (AVV).
        </p>
    </div>
    <div class="col-6">
        @if (!is_null($measure->measureImage()))
            <img class="img-fluid" src="{{ \Illuminate\Support\Facades\Storage::disk('s3_public')->url($measure->measureImage()->name) }}" alt="Maßnahmenbild">
        @endif
    </div>
</div>
@include('backend.measures.partials.createUpdateModal')