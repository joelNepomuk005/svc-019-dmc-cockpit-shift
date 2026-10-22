<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'S-Markt & Mehrwert') }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="{{ empty($robots) ? "index,follow,noarchive" : $robots }}">
    <meta name="author" content="S-Markt und Mehrt GmbH & Co. KG">
    <meta name="publisher" content="S-Markt und Mehrt GmbH & Co. KG">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0,initial-scale=1.0">
    <link rel="stylesheet" href="{{ config('app.sdk_url') }}/styles/sdk.css">
    <link rel="stylesheet" href="/styles/app.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="content-style-type" content="text/css">
    <meta http-equiv="content-script-type" content="text/javascript">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0,initial-scale=1.0">
    <link rel="stylesheet" href="/styles/app.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/styles/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/styles/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/styles/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/styles/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="/styles/images/favicons/safari-pinned-tab.svg" color="#ff0000">
    <link rel="shortcut icon" href="/styles/images/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="/styles/images/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <script>var SMM = SMM || {}; SMM.app = SMM.app || {};</script>
</head>

<body id="auth-layout" class="SMM-skin bg-primary" style="background-image: url('../storage/hero_image.jpg')">
<div id="site-body">
    <main>
        @yield('content')
    </main>
</div>

<div id="site-footer" class="bg-dark py-2">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <aside>
                        <p class="m-0 py-2 text-white">&copy; <?php echo date('Y'); ?> S-Markt & Mehrwert GmbH & Co. KG. Alle Rechte vorbehalten.</p>
                    </aside>
                </div>
                <div class="col-7">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <ul class="navbar-nav m-0 ms-auto">
                            <li class="nav-item mx-1"><a href="https://jetztallesmoeglich.de/frontend/impressum"  target="_blank" class="text-white text-decoration-none">Impressum</a></li>
                            <li class="nav-item mx-1"> <a data-bs-toggle="modal" data-bs-target="#showContactModal" href="{{ route('showModal') }}" data-ajax class="text-white text-decoration-none">Kontakt</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </footer>
</div>
@include('layouts.partials.modal.showModal')

@stack('modal')

<script src="{{ config('app.sdk_url') }}/scripts/vendor.js"></script>
<script src="{{ config('app.sdk_url') }}/scripts/sdk.js"></script>
<script src="{{ mix('/scripts/app.js') }}"></script>
<script src="{{ mix('/scripts/vendor.js') }}"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


@toastr_js
@toastr_render

@stack('js')


</body>
</html>
