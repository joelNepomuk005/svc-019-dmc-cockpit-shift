@extends('layouts.backend')

@section('content')

    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent px-0 py-0">
                        <li class="breadcrumb-item"><a href="/">Startseite</a></li>
                        <li class="breadcrumb-item active">Fehler</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 dark-font">
                <section class="magazine-section text-center my-5">
                    <h2 class="h1-responsive font-weight-bold text-center my-5">Fehler <small>401</small></h2>
                    <p class="text-center dark-grey-text w-responsive mx-auto mb-5">Zur Nutzung dieser Seite ist eine Authentifizierung erforderlich.</p>
                    <p class="text-center dark-grey-text w-responsive mx-auto mb-5"> <a href="/">Zurück zur Startseite <i class="fas fa-angle-double-right"></i></a></p>
                </section>
            </div>
        </div>
    </div>

@endsection
