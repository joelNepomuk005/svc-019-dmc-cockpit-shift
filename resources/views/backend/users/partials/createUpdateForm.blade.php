@if($modal == 'create')
    <form action="{{ route('backend.users.store', $user)}}" method="POST" data-ajax enctype="multipart/form-data">
@else
    <form action="{{route('backend.users.{user}.update', $user)}}" method="POST" data-ajax enctype="multipart/form-data">
@endif
    <div class="modal-content">
        <div class="modal-header">
            <div class="container pl-0 pr-0">
                <div class="row">
                    <div class="col-12">
                        @if($modal == 'create')
                            <h5 class="modal-title" id="createUserLabel">Person erstellen </h5>
                        @else
                            <h5 class="modal-title" id="createUserLabel">Person bearbeiten <small>(#{{ $user->id . ' ' . $user->name }})</small></h5>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group form-floating mb-3">
                                    <select name="customer_id" id="customer_id" class="selectpicker w-100 btn-block" aria-label="size 3 select example" title="Sparkasse" data-live-search="true" {{ !empty($user->manager_id) ? 'disabled' : '' }}>
                                        <option value="" readonly disabled>Sparkasse</option>
                                        @foreach(\App\Models\Customer::all() as $customer)
                                            <option value="{{ $customer->id }}" {{ @old('customer_id', $customer->id) == $user->customer_id ? 'selected' :  '' }}>{{ $customer->name  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group form-floating mb-3">
                                    <select name="salutation" id="salutation" class="selectpicker w-100 btn-block" aria-label="size 3 select example" title="Anrede" data-live-search="true">
                                        <option value="" readonly disabled>Anrede</option>
                                        <option value="male" {{ @old('salutation', $user->salutation) == 'male' ? 'selected' :  '' }}>Herr</option>
                                        <option value="female" {{ @old('salutation', $user->salutation) == 'female' ? 'selected' :  '' }}>Frau</option>
                                        <option value="divers" {{ @old('salutation', $user->salutation) == 'divers' ? 'selected' :  '' }}>Divers</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group form-floating mb-3">
                                    <input id="first_name" type="text" class="form-control" name="first_name" value="{{ !empty($user->first_name) ? $user->first_name : ''}}">
                                    <label for="first_name" class="active">Vorname*</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group form-floating mb-3">
                                    <input id="last_name" type="text" class="form-control" name="last_name" value="{{ !empty($user->last_name) ? $user->last_name : ''}}">
                                    <label for="last_name" class="active">Nachname*</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group form-floating mb-3">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ !empty($user->email) ? $user->email : ''}}">
                                    <label for="email" class="active">Email*</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group form-floating mb-3">
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ !empty($user->phone) ? $user->phone : ''}}">
                                    <label for="phone" class="active">Telefon</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group form-floating mb-3">
                                    <select name="categorie_id" id="categorie_id" class="selectpicker w-100 btn-block" aria-label="size 3 select example" title="Rolle" data-live-search="true">
                                        @foreach(\App\Models\UserCategories::all() as $categorie)
                                            <option value="{{ $categorie->id }}" {{ !is_null($categorie->id) ? $categorie->id == $user->categorie_id ? 'selected' : '' : ''}}>{{ $categorie->name  }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
