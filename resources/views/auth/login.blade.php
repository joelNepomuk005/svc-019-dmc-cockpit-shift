@extends('layouts.auth')

@section('content')

    <div class="container mb-5">
        <div class="row justify-content-left align-items-center vh-100">
            <div class="col-md-6 col-lg-6">
                <div class="bg-white shadow p-5 p-md-5">
                    <div class="">
                        <form method="POST" action="{{ route('login') }}">
                            <fieldset>
                                @csrf
                            </fieldset>

                            <div class="mb-3">
                                <h1 class="h4 mb-3">Anmeldung</h1>
                                <h2 class="h6">Willkommen beim DMC Cockpit.</h2>
                                <p>
                                    <br>
                                    Wenn Sie bereits beim DMC-Cockpit registriert sind,
                                    benötigen Sie für den Login lediglich Ihre Dienst
                                    -Email-Adresse und Ihr Passwort.<br><br>

                                    Sie haben noch keinen Zugang zum DMC-Cockpit?
                                    Dann können Sie sich in nur wenigen Schritten registrieren.
                                    Alles was Sie benötigen, ist eine personalisierten (dienstliche)<br>
                                    E-Mail-Adresse Ihrer Sparkasse, dann vergeben Sie noch ein Passwort
                                    – schon steht Ihnen das DMC-Cockpit zur Verfügung offen.

                                </p>
                            </div>
                            <div class="form-floating mb-3 mt-5">
                                <input type="email" name="email" id="email" value="{{old('email')}}" required autocomplete="email" autofocus class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="email">Benutzername (E-Mail-Adresse)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" id="password" value="" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="password">Passwort</label>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" role="switch" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="form-check-input">
                                <label for="remember" class="form-check-label">Anmeldung speichern</label>
                            </div>
                            <div class="row mt-3 pt-3 border-top">
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <button type="submit" class="d-block w-100 btn btn-primary text-white">Anmelden</button>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3 mb-3 mt-md-0">
                                    <div class="text-center">
                                        <a class="d-block w-100 btn btn-primary text-white" href="{{ route('check_blz') }}">Registrieren</a>
                                    </div>
                                </div>
                                @if (Route::has('password.request'))
                                    <div class="col-md-7 mt-md-0">
                                        <div class="text-left">
                                            <a class="btn btn-link text-black" href="{{ route('password.request') }}">Passwort vergessen?</a>
                                        </div>
                                    </div>
                                @endif
                                <hr >
                                <div class="row">
                                <div class="col-md-7  mt-md-0">
                                    <div class="text-left">
                                        <a class="btn btn-link text-red" target="_blank" href="{{  asset('../storage/Registrierungsprozess.pdf') }}">Download Kurzanleitung Registrierung</a>
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
