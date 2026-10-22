@if($modal == 'create')
    <form action="{{ route('backend.customers.{customer}.budgets.{type}.store', [$customer, $type])}}" method="POST" data-ajax enctype="multipart/form-data">
@else
    <form action="{{route('backend.customers.{customer}.budgets.{budget}.{type}.update', [$customer, $budget, $type])}}" method="POST" data-ajax enctype="multipart/form-data">
        @method('PUT')
@endif
    <div class="modal-content">
        <div class="modal-header">
            <div class="container pl-0 pr-0">
                <div class="row">
                    <div class="col-12">
                        @if($modal == 'create')
                            <h5 class="modal-title" id="createUserLabel">Budget erstellen </h5>
                        @else
                            <h5 class="modal-title" id="createUserLabel">Budget bearbeiten <small>(#{{ $budget->id }})</small></h5>
                        @endif
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
                            <span></span> <i class="fa fa-info-circle"  style="color: grey !important;float: right"  data-bs-toggle="tooltip" data-bs-placement="right" title="Bei Minus Beträgen ein Minuszeichen vor den Betrag setzten"></i>
                            <br>
                            <div class="form-group form-floating mb-3">
                                <input id="amount" name="amount" type="text" class="form-control" required value="{{ old('amount', $budget->amount) }}">
                                <label for="amount" class="active">Betrag<sup>*</sup></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <div class="form-group form-floating mb-3">
                                <select name="measure_id" id="measure_id" class="selectpicker w-100 btn-block" data-live-search="true">
                                    @foreach(\App\Models\CustomerMeasures::where('customer_id', $customer->id)->get() as $customerMeasure)
                                        <option value="{{ $customerMeasure->measure->id }}" {{ old('measure_id', $budget->measure_id) == $customerMeasure->measure->id ? 'selected' : '' }}>{{ $customerMeasure->measure->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <textarea class="form-control" id="note" name="note" rows="3" required>{{ old('note', $budget->note) }}</textarea>
                            <label for="notes" class="active">Kommentar *</label>
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