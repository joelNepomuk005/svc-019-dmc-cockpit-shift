@extends('layouts.auth')

@section('content')

    <div class="container">
        <div class="row justify-content-left align-items-center vh-100">
            <div class="col-md-6 col-lg-6">
                <div class="bg-white shadow p-5 p-md-5">
                    <div class="">
                        <form method="GET" action="{{ route('verify_blz') }}">
                            <fieldset>
                                @csrf
                            </fieldset>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-5">
                                        <h1 class="h4 mb-3">Registrierung</h1>
                                        <p>
                                            Bitte geben Sie die Bankleitzahl Ihrer Sparkasse ein.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <section>
                                            <div class="accordion" id="accordionExample">
                                                <div class="steps">
                                                    <progress id="progress" value=0 max=100 ></progress>
                                                    <div class="step-item">
                                                        <button class="step-button text-center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            1
                                                        </button>
                                                    </div>
                                                    <div class="step-item">
                                                        <button class="step-button text-center collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            2
                                                        </button>
                                                    </div>
                                                    <div class="step-item">
                                                        <button class="step-button text-center collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            3
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                    </section>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="blz" name="blz" id="blz" value="{{old('blz')}}" required autocomplete="blz" autofocus class="form-control @error('blz') is-invalid @enderror">
                                @error('blz')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="email">*BLZ</label>
                            </div>
                            <div class="row mt-3 pt-3 border-top">
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <a href="{{ route('login') }}" class="d-block w-100 btn btn-secondary text-white">Zurück zum Login</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <button type="submit" class="d-block w-100 btn btn-primary text-white">Weiter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>


    </style>
@endsection
