<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="showMeasuresLabel">Maßnahme anzeigen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="container pl-0 pr-0">
            <div class="row mt-5 ">
                <div class="col-6 border-end">
                    <h2 class="mb-5">{{$measure->name}} ({{$measure->from->format('d.m.y') .' - '.$measure->to->format('d.m.y')}})</h2>

                    <span class="mb-5 mt-5">Status: {!! $measure->getBadgeInformation(Auth::user()->customer->id)  !!}</span>
                    <div class="row fs-5  mt-5">
                        <div class="col-auto">
                            <i class="fas fa-archive" aria-hidden="true"></i>
                        </div>
                        <div class="col">
                            @if (!is_null($measure->promotionPackage()))
                                <a href="{{ route('backend.files.downloadFile', $measure->promotionPackage()) }}"> <span><b>Download Neuer Select  </b></span> <i class="fa fa-info-circle" style="color: red!important;" data-bs-toggle="tooltip" data-bs-placement="right" title="Herunterladen"></i></a>
                            @else
                                <span><b>Download Neuer Select  </b></span> <i class="fa fa-info-circle"  style="color: grey !important;"  data-bs-toggle="tooltip" data-bs-placement="right" title="Die Werbemittel werden rechtzeitig vor Kampagnenstart zum Download bereitgestellt"></i>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        @if($measure->getMeasureState(Auth::user()->customer->id) == 'offen')
                            <a href="{{ route('backend.measures.{measure}.showMeasure', $measure) }}" class="btn btn-primary btn-xl w-25 mb-5 mt-5">Maßnahme buchen</a>
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    @if (!is_null($measure->measureImage()))
                        <img class="measure-image" src="{{ \Illuminate\Support\Facades\Storage::disk('s3_public')->url($measure->measureImage()->name) }}" alt="Maßnahmenbild">
                    @endif

                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Schließen</button>
    </div>
</div>
