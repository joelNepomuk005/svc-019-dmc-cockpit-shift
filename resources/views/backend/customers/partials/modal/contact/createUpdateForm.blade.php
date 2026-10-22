@if($modal == 'create')
    <form action="{{route('backend.customers.{customer}.contact.store', $customer)}}" method="POST" data-ajax enctype="multipart/form-data">
@else
    <form action="{{route('backend.customers.{customer}.contact.{customerContact}.update', [$customer, $customerContact])}}" method="POST" data-ajax enctype="multipart/form-data">
@endif
    <div class="modal-content">
        <div class="modal-header">
            @if($modal == 'create')
                <h5 class="modal-title" id="createContactLabel">Kontakt erstellen <small>({{ $customer->name }})</small></h5>
            @else
                <h5 class="modal-title" id="createContactLabel">Kontakt bearbeiten <br><small>{{ $customerContact->customer->name }}</small></h5>
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="container pl-0 pr-0">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <select name="user_id" id="user_id" class="selectpicker w-100 btn-block" aria-label="size 3 select example" title="Erfasser">
                                @if (!empty($customerContact->user_id))
                                    <option value="{{ $customerContact->user_id }}" selected disabled>{{ $customerContact->user->name }}</option>
                                @else
                                    <option value="{{ \Illuminate\Support\Facades\Auth::user()->id }}" selected readonly>{{ \Illuminate\Support\Facades\Auth::user()->name }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <select name="contact_type_id" id="contact_type_id" class="selectpicker w-100 btn-block" aria-label="size 3 select example" title="Kontaktart" required data-live-search="true">
                                <option value="" readonly disabled>Kontaktart</option>
                                @foreach(\App\Models\ContactType::all() as $type)
                                    <option value="{{ $type->id }}" {{ @old('contact_type_id', $customerContact->contact_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <select name="contact_person_id" id="contact_person_id" class="selectpicker w-100 btn-block" aria-label="size 3 select example" title="Ansprechpartner" data-live-search="true" data-done-button="true" required data-done-button-text="Schließen">
                                @foreach($customer->users as  $user)
                                    <option value="{{$user->id}}" {{ @old('contact_person_id', $customerContact->contact_person_id) == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="alert alert-info">
                            <p>Falls Ihr Ansprechpartner nicht angezeigt wird, können Sie <a href="{{ route('backend.customers.{customer}.users.create', $customer) }}" data-bs-toggle="modal" data-bs-target="#createUserModal" data-ajax>hier</a> einen neuen Kontakt anlegen.</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <input id="date" name="date" type="date" class="form-control" value="{{ !empty($customerContact->date) ? $customerContact->date->format('Y-m-d') : null }}">
                            <label for="date" class="active">Datum</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group form-floating mb-3">
                            <textarea id="title" name="title" class="form-control" style="min-height: 150px">{{!empty($customerContact->title) ? $customerContact->title : null }}</textarea>
                            <label for="title" class="active">Betreff</label>
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
@include('backend.customers.partials.modal.user.createUpdateModal')