@if($modal == 'create')
    <form action="{{ route('backend.measures.store', $user)}}" method="POST" data-ajax enctype="multipart/form-data">
@else
    <form action="{{route('backend.measures.{measure}.update', $user)}}" method="POST" data-ajax enctype="multipart/form-data">
        @method('PUT')
@endif
    <div class="modal-content">
        <div class="modal-header">
            <div class="container pl-0 pr-0">
                <div class="row">
                    <div class="col-12">
                        @if($modal == 'create')
                            <h5 class="modal-title" id="createUserLabel">Maßnahme erstellen </h5>
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
                            <input id="name" type="text" class="form-control" name="name" value="{{ !empty($measure->name) ? $measure->name : ''}}">
                            <label for="name" class="active">Name <sup>*</sup></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group form-floating mb-3">
                            <input id="from" type="date" class="form-control" name="from" value="{{ !empty($measure->from) ? $measure->from : ''}}" required>
                            <label for="from" class="active">Von <sup>*</sup></label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-floating mb-3">
                            <input id="to" type="date" class="form-control" name="to" value="{{ !empty($measure->to) ? $measure->to : ''}}" required>
                            <label for="to" class="active">Bis <sup>*</sup></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group form-floating mb-3">
                            <select name="user_id" id="user_id" class="selectpicker w-100 btn-block" aria-label="size 3 select example" title="Erfasser" data-live-search="true">
                                <option value="" readonly disabled>Erfasser</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ @old('user_id', $customerContact->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-floating mb-3">
                            <select name="customer_ids[]" id="customer_ids" class="selectpicker w-100 btn-block" multiple aria-label="size 3 select example" title="Institute" data-live-search="true" data-done-button="true" required data-done-button-text="Schließen">
                                <option value="0">Alle</option>
                            @foreach(\App\Models\Customer::all() as  $customer)
                                    <option value="{{$customer->id}}" {{ !is_null($measure->customer_ids)  ? in_array($customer->id, $measure->customer_ids) ? 'selected' : '' : ''}}>{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="row">
                        <label class="custom-file-label" for="file">Werbemittelpaket auswählen</label>
                        <div class="col-12">
                            <div class="form-group form-floating mb-3">
                                <input type="file" id="promotion_package" name="promotion_package" placeholder="Datei auswählen oder ablegen..."  class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <label class="custom-file-label" for="file">Bild auswählen</label>
                        <div class="col-12">
                            <div class="form-group form-floating mb-3">
                                <input type="file" id="measure_image" name="measure_image" placeholder="Datei auswählen oder ablegen..."  class="form-control">
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