@extends('layouts.auth')

@section('content')

    <div class="container">
        <div class="row justify-content-left align-items-center my-3">
            <div class="col-md-6 col-lg-6">
                <div class="bg-white shadow p-5 p-md-5">
                    <div class="">
                        <form method="POST" action="{{ route('register_user') }}">
                            <fieldset>
                                @csrf
                            </fieldset>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-5">
                                        <h1 class="h4 mb-3">Registrierung</h1>
                                        <p>
                                            <br>
                                            Bitte tragen Sie hier Ihre Daten ein und bestätigen Sie<br>
                                            die Teilnahmebedingungen. Wir werden Ihr Konto in Kürze manuell freigeben.<br>
                                            Bitte melden Sie sich zukünftig mit der angegebenen E-Mail-Adresse<br>
                                            und dem von Ihnen gewählten Kennwort an.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <section>
                                            <div class="accordion" id="accordionExample">
                                                <div class="steps">
                                                    <progress id="progress" value=50 max=100 ></progress>
                                                    <div class="step-item">
                                                        <button class="step-button text-center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            1
                                                        </button>
                                                    </div>
                                                    <div class="step-item">
                                                        <button class="step-button text-center collapsed done" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
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

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="sex" class= "col-md-6 col-form-label text-md-right ">Geschlecht</label>
                                    <div class="form-check form-check-inline" >
                                        <input class="form-check-input" type="radio" name="sex" value="male" {{ old('sex') == 'male' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="male">Herr</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sex" value="female" {{ old('sex') == 'female' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="female">Frau</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-group form-floating">
                                        <input  class="form-control  @error('first_name') is-invalid @enderror" id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required>
                                        <label for="first_name">
                                            Vorname<sup>*</sup>
                                        </label>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group form-floating">
                                        <input  class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required>
                                        <label for="last_name">
                                            Nachname<sup>*</sup>
                                        </label>
                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group form-floating">
                                        <input  class="form-control @error('job_title') is-invalid @enderror" id="job_title" name="job_title" type="text" value="{{ old('job_title') }}" required>
                                        <label for="job_title">
                                            Berufsbezeichnung *
                                        </label>
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group form-floating">
                                        <input  class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="text" value="{{ old('phone') }}" required>
                                        <label for="phone">
                                            Telefonnummer *
                                        </label>
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group form-floating">
                                        <input  class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required>
                                        <label for="email">
                                            Email-Adresse<sup>*</sup>
                                        </label>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group form-floating">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        <label for="password-confirm">
                                            Passwort<sup>*</sup>
                                        </label>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group form-floating">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        <label for="password-confirm">
                                            Passwort Wiederholen<sup>*</sup>
                                        </label>
                                        @error('password-confirm')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-5">
                                        <div class="col-9">
                                            <b>Datenschutzhinweise</b>
                                            <div class="form-group form-floating mt-3">
                                                <input name="dsgvo" id="dsgvo" value="1" type="checkbox" class="form-check-input" required  {{ old('dsgvo') == 1 ? 'checked' : null }}>
                                                <label for="dsgvo" class="form-check-label proceed-label custom-label-register">Ich habe die <a href="{{ route('shared.privacy') }}" target="_blank">Datenschutzhinweise</a> zur Kenntnis genommen.</label>
                                            </div>
                                        </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <input hidden id="blz" name="blz" type="text" value="{{$blz}}" required>

                            <div class="row mt-3 pt-3 border-top">
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <a href="{{ route('login') }}" class="d-block w-100 btn btn-secondary text-white">Zurück zum Login</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <button type="submit" class="d-block w-100 btn btn-primary text-white">Registrieren</button>
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
