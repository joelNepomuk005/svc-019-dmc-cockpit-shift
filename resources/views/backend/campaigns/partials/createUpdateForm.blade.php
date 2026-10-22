@if($modal == 'create')
    <form action="{{ route('backend.campaigns.store')}}" method="POST" data-ajax enctype="multipart/form-data">
@else
    <form action="{{route('backend.campaigns.{campaign}.update', $campaign)}}" method="POST" data-ajax enctype="multipart/form-data">
        @method('PUT')
@endif
    <div class="modal-content">
        <div class="modal-header">
            <div class="container pl-0 pr-0">
                <div class="row">
                    <div class="col-12">
                        @if($modal == 'create')
                            <h5 class="modal-title" id="createUserLabel">Wettbewerb erstellen </h5>
                        @endif
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container pl-0 pr-0">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group form-floating mb-3">
                            <input id="prefix" type="text" class="form-control" name="prefix" value="{{ !empty($campaign->prefix) ? $campaign->prefix : ''}}" required>
                            <label for="prefix" class="active">Prefix<sup>*</sup></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group form-floating mb-3">
                            <input id="name" type="text" class="form-control" name="name" value="{{ !empty($campaign->name) ? $campaign->name : ''}}">
                            <label for="name" class="active">Name <sup>*</sup></label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-floating mb-3">
                            <input id="title" type="text" class="form-control" name="title" value="{{ !empty($campaign->title) ? $campaign->title : ''}}" required>
                            <label for="title" class="active">Titel<sup>*</sup></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <textarea id="subheadline" type="text" class="form-control" name="subheadline" style="height: 150px" required>{{ !empty($campaign->subheadline) ? $campaign->subheadline : ''}}</textarea>
                            <label for="subheadline" class="active">Subheadline <sup>*</sup></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group form-floating mb-3">
                            <input id="link" type="text" class="form-control" name="link" value="{{ !empty($campaign->link) ? $campaign->link : ''}}">
                            <label for="link" class="active">Link <sup>*</sup></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group form-floating mb-3">
                            <input id="start_date" type="date" class="form-control" name="start_date" value="{{ !empty($campaign->start_date) ? $campaign->start_date : ''}}" required>
                            <label for="start_date" class="active">Von <sup>*</sup></label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-floating mb-3">
                            <input id="end_date" type="date" class="form-control" name="end_date" value="{{ !empty($campaign->end_date) ? $campaign->end_date : ''}}" required>
                            <label for="end_date" class="active">Bis <sup>*</sup></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group form-floating mb-3">
                            <select name="customer_ids[]" id="customer_ids" class="selectpicker w-100 btn-block" multiple aria-label="size 3 select example" title="Institute" data-live-search="true" data-done-button="true" data-done-button-text="Schließen">
                                <option value="0" id="select-all-option">Alle</option>
                            @foreach(\App\Models\Customer::all() as  $customer)
                                    <option value="{{$customer->id}}" {{ !is_null($measure->customer_ids)  ? in_array($customer->id, $measure->customer_ids) ? 'selected' : '' : ''}}>{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <label class="custom-file-label" for="file">Excel-Datei für Sparkassen-Upload auswählen</label>
                        <div class="col-12">
                            <div class="form-group form-floating mb-3">
                                <input type="file" id="customer_upload" name="customer_upload" placeholder="Excel-Datei auswählen..." class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="row">
                            <div class="row">
                                <div class="col">
                                    <label class="custom-file-label" for="file">
                                        Bilder für den Wettbewerb auswählen
                                        <i class="fa fa-info-circle" style="color: grey !important;" data-bs-toggle="tooltip" data-bs-placement="right" title="Bitte laden Sie nur Bilder im Format 2400px x 1050px hoch"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group form-floating mb-3">
                                <input type="file" id="campaign_images" name="campaign_images[]" placeholder="Datei auswählen oder ablegen..." class="form-control" multiple>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Abbrechen</button>
            <button type="submit" class="btn btn-primary">Speichern</button>
        </div>
    </div>
</form>