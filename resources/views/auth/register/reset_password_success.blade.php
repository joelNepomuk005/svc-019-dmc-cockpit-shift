@extends('layouts.auth')

@section('content')

    <div class="container">
        <div class="row justify-content-left align-items-center vh-100">
            <div class="col-md-6 col-lg-6">
                <div class="bg-white shadow p-5 p-md-5">
                    <div class="">
                            <div class="mb-5">
                                <h1 class="h4 mb-3 text-primary">Registrierung</h1>
                                <p>
                                    Ihre Passwort wurde erfolgreich gespeichert.
                                </p>
                            </div>
                        <div class="row mt-3 pt-3 border-top">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <a href="{{route ('login')}}" class="d-block w-100 btn btn-primary text-white">Jetzt anmelden</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
