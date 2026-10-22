
<form action="{{route('backend.customers.{customer}.measures.{measure}.updateOnCustomer', [$customer, $measure])}}" method="POST" data-ajax enctype="multipart/form-data">
    @method('PUT')
    <div class="modal-content">
        <div class="modal-header">
            <div class="container pl-0 pr-0">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="createUserLabel">Maßnahme buchen</h5>
                    </div>
                    <div class="col-12">
                        <h6 class="modal-title" id="createUserLabel">{{$customer->name}}</h6>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container pl-0 pr-0">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <input type="hidden" name="measure_id" value="{{ $measure->id }}">
                            <input id="name" type="text" class="form-control" value="{{ !empty($measure->name) ? $measure->name : ''}}" disabled>
                            <label for="name" class="active">Maßnahme <sup>*</sup></label>
                        </div>
                    </div>
                    @can('main_menu_measures')
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <select name="state" id="state" class="selectpicker w-100 btn-block" aria-label="size 3 select example" title="Status" data-live-search="true">
                                <option value="" readonly disabled>Status</option>
                                @foreach(\App\Enums\Variables::$measuresStates['states'] as $key => $state)
                                    @if($state['name'] != 'offen')
                                    <option value="{{ $key }}" {{ @old('state', $customerMeasure->state) == $key ? 'selected' : '' }}>{{ $state['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('state')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    @endcan

                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <input id="from" type="date" min="{{$measure->from}}" max="{{$measure->to}}" name="from" class="form-control" value="{{ old('from', $measure->from) ? $measure->from->format('Y-m-d') : '' }}" >
                            <label for="from" class="active">Start-Datum <sup>*</sup></label>
                            @error('from')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <input id="to" type="date" min="{{$measure->from}}" max="{{$measure->to}}" name="to" class="form-control" value="{{ old('to', $measure->to) ? $measure->to->format('Y-m-d') : '' }}" >
                            <label for="to" class="active">End-Datum <sup>*</sup></label>
                            @error('to')
                            <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="hidden" name="incentivization" value="1">
                        <label for="incentivization" class="active">Cashback gewünscht <sup>*</sup></label>
                        <div class="form-group form-floating mb-3">
                            <select name="incentivization" id="incentivization" class="selectpicker w-100 btn-block" aria-label="size 3 select example" title="Cashback gewünscht" disabled>
                                <option value="1" selected>Ja</option>
                            </select>
                            @error('incentivization')
                            <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div style="display: none" class="col-12">
                        <div class="form-group form-floating mb-3">
                            <select name="coupon" id="coupon" class="selectpicker w-100 btn-block" aria-label="size 3 select example" title="Coupon" data-live-search="true">
                                <option value="" readonly disabled>Coupons</option>
                                <option value="0" {{ @old('coupon', $customerMeasure->coupon) == 0 ? 'selected' : '' }}>Nein</option>
                                <option value="1" {{ @old('coupon', $customerMeasure->coupon) == 1 ? 'selected' : '' }}>Ja</option>
                            </select>
                            @error('coupon')
                            <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div id="cashbackContainer" class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group form-floating mb-3">
                                    <input type="number" class="form-control" id="cashback" name="cashback">
                                    <label for="cashback" class="active">Max. Summe an auszugegebenen Cashback (in €)</label>
                                    @error('cashback')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input type="checkbox" role="switch" id="cashback_unlimited" name="cashback_unlimited" value="1" class="form-check-input">
                                    <label class="form-check-label" for="cashback_unlimited">Ohne Begrenzung</label>
                                    @error('cashback_unlimited')
                                    <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Abbrechen</button>
            <button type="submit" class="btn btn-primary">Maßnahme buchen</button>
        </div>
    </div>

    <script type="text/javascript">
        $('#incentivization').change(function () {
            if (this.value === '1') {
                $('#cashbackContainer').show();
            } else {
                $('#cashbackContainer').hide();
            }
        });

        $('#cashback_unlimited').change( function () {
            if (this.checked) {
                $('#cashback').prop('disabled', true);
            } else {
                $('#cashback').prop('disabled', false);
            }
        });
    </script>
</form>
