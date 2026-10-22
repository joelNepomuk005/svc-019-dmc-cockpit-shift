@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('backend.customer.edit', $customer) }}
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card shadow">
                    <div class="card-body bg-white px-0 py-0">
                        @if($errors->any())
                            <div class="alert alert-warning" role="alert">
                                {!! implode('', $errors->all('<div>:message</div>')) !!}
                            </div>
                        @endif

                        <form action="{{route('backend.customers.{customer}.update', $customer)}}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row d-flex">


                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-9 col-xxl-9 p-3 align-self-stretch">
                                    <div class="p-4">
                                        <div class="tab-content vertical">
                                            <div class="tab-pane fade in show active" id="form-tab-1" role="tabpanel">
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <header>
                                                            <h3 class="h5">Angaben zur Sparkasse</h3>
                                                        </header>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group form-floating mb-3">
                                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $customer->name) }}">
                                                            <label for="name" class="active">Institutsname <sup>*</sup></label>
                                                        </div>
                                                        @if ($errors->has('name'))
                                                            <div class="error-message" id="name">
                                                                <div class="alert alert-danger" role="alert"><p>{{ $errors->first('name') }}</p></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group form-floating mb-3">
                                                            <select name="association_id" id="association_id" class="selectpicker w-100 btn-block" aria-label="" title="Verband" data-live-search="true">
                                                                <option value="" readonly disabled>Verband</option>
                                                                @foreach(\App\Models\CustomerAssociation::all() as $association)
                                                                    <option value="{{ $association->id }}" {{ @old('association_id', $association->id) == $customer->association_id ? 'selected' : '' }}>{{ $association->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @if ($errors->has('association_id'))
                                                            <div class="error-message" id="name">
                                                                <div class="alert alert-danger" role="alert"><p>{{ $errors->first('association_id') }}</p></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group form-floating mb-3">
                                                            <input id="blz" type="text" class="form-control" name="blz" value="{{ old('blz', $customer->blz) }}">
                                                            <label for="blz" class="active">Bankleitzahl <sup>*</sup></label>
                                                        </div>
                                                        @if ($errors->has('blz'))
                                                            <div class="error-message" id="blz">
                                                                <div class="alert alert-danger" role="alert"><p>{{ $errors->first('blz') }}</p></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group form-floating mb-3">
                                                            <input id="bic" type="text" class="form-control" name="bic" value="{{ old('bic', $customer->bic) }}">
                                                            <label for="bic" class="active">BIC <sup>*</sup></label>
                                                        </div>
                                                        @if ($errors->has('bic'))
                                                            <div class="error-message" id="bic">
                                                                <div class="alert alert-danger" role="alert"><p>{{ $errors->first('bic') }}</p></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 col-xxl-3 align-self-stretch bg-accent border-left border-light">
                                    <div class="d-flex align-items-start py-3 h-75">
                                        <div class="w-100">
                                            <ul class="nav nav-pills nav-fill nav-pills-vertical navbar-light text-center flex-column" role="tablist" aria-orientation="vertical">
                                                <li class="nav-item px-0"><a class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tab-1" type="button" role="tab" aria-controls="" aria-selected="true">Übersicht</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end h-25">
                                        <div class="w-100 py-3 px-3">
                                        <span data-double-submit role="button" class="d-flex w-100">
                                            <span class="locked d-block w-100 justify-content-center">
                                                <button type="button" role="button" data-alert="" class="btn d-block btn-link w-100">
                                                    <i aria-hidden="true" class="me-2 fas fa-lock"></i>Abbrechen?
                                                </button>
                                            </span>
                                            <span role="button" class="unlocked d-none w-100">
                                                <span class="btn-group d-flex justify-content-center w-100" role="group" aria-label="">
                                                    <button type="button" role="button" data-submit="link||{{route('backend.customers.index')}}" class="btn btn-dark px-3">ja</button>
                                                    <button type="button" role="button" data-cancel="" class="btn btn-dark px-3">nein</button>
                                                    <span class="btn btn-primary flex-grow-3 px-3"><i aria-hidden="true" class="d-inline-block me-2 fa fa-lock-open"></i>Abbrechen</span>
                                                </span>
                                            </span>
                                        </span>
                                            <hr>
                                            <button type="submit" class="btn btn-primary text-white d-block w-100">Speichern</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection