<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <!--

                    **                                                  ***     **
                    ***   *                  *                          ****   ****
                   ***** ****                ***                       ****** *****
                   ***** ****               *****                      *****  *****
                  *****  ****               ****  **                  *****  *****                                              *
                  ****  ***                ****   ***                 *****  *****                                             ***
                 ****   **                 **    *****               *****  *****                                             *****
                 ****                      ***   *****              *****   ****                                        ***   *****
                ****                       ********************     *****  ****                                         *********************
               ****                        ****************        *****   ****                                         ****************
               ****                        *********               *****  ****                                           ********
           *******   **      ****       **     ****      ****     *****   ***       ***           **     **        ****     ****  ***           ****       ***
          ********  ****    ******     ****    ****     ******    ****   ********   ****         ****   ****     ******     ****  ****   **    ******     ****
         ********  ******  *******     *****  ****    ********   *****   *********  ****   ***   ****  ******   ********   ****   *****  ***   *****     ******
        ********   *****   ****       *****   ***    *********   ****   ***** **** *****   ***   ***********   ********    ****  *****  ***** ****      *******
       *********  *****   **** ****   ****   ****    ***** **   ****   *****  **** ****   ***** ****** ****   ****** **   ****   ****   ****   ******* ****** *
      ***** ***   ****   ****  ***** *****  ****    ***** **** *****   ****  **** *****   ****  ***** *****  *****  ***   ***   ****   ****   ******** ***** **
     *****  ***  *****  ***** ****** ****  *****   ***** ***** ****   ****   **** ****   ***** ***** *****  *****  ****  ****   ****  ****   ** *********** **  *
     ****  ***   ****  ***** ****** ****  *****   ***** ***** *****   ***   **** ****   *****  ****  ****  *****  ****   ***   ****   ****  ** *****  *******  *
    ***** ****  ****  ***** ******  **** ******  ***** *****  ****  *****  ***** ****  *****  ****  ****  *****  *****  ****  ****   ****  ** *****  ******   **
    ****  **** ***** ************* **** ** *** ****** *****   **** *****  ***** ****  ******  ****  **** *****  * ***   *** ******  ****  **  ****   *****   **
    ****  **** ***** ** **********  *** ** ****** *** ** ***  **** ** *** *****  **** ** ***  ****  *********** *****   ****** *** ****** **   ****  ****   ***
    ****************** ****** ****  *****  *****  ***** ***   ****** *********   *** ** ****  ***   ****** ****** ***   ************ ******    *** ** ***  ***
    ***** ****  ****   ****  ***   ****  *****   ****  ***   *****   *******    *****  ***  ****   *****  *****  ***   ***** *****  *****     ****** *******
     ***  ***   ***    ***  ***    ***    ***    ***    **    ***     ****      ****  ****   **     ***    **    **    ****   ***    ***       ***    ****
      *                 *   ***            *      *            *       *              ***            *            *     *      *      *         *
                           ***                                                       ****
                           ***                                                       ***
                          ***                                                       ****
                          ***                                                       ***
                         ***                                                       ***
                         ***                                                       ***
                         ***                                                      ***
                        ***                                                       ***
                        ***                                                      ***
                       ***                                                       ***
                      ****                                                      ****
                     ****                                                      ****
                       **                                                       **

    digitalbynature® </> internet and so agency
    ahoy@digitalbynature.de

    -->

    <title>{{ config('app.name', 'S-Markt & Mehrwert') }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="noindex,nofollow,noarchive">
    <meta name="author" content="digitalbynature GmbH">
    <meta name="publisher" content="S-Markt und Mehrt GmbH & Co. KG">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="content-style-type" content="text/css">
    <meta http-equiv="content-script-type" content="text/javascript">
    <link rel="stylesheet" href="{{ config('app.sdk_url') }}/styles/sdk.css">
    <link rel="stylesheet" href="/styles/app.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('app.sdk_url') }}/styles/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ config('app.sdk_url') }}/styles/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ config('app.sdk_url') }}/styles/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="{{ config('app.sdk_url') }}/styles/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="{{ config('app.sdk_url') }}/styles/images/favicons/safari-pinned-tab.svg" color="#ff0000">
    <link rel="shortcut icon" href="{{ config('app.sdk_url') }}/styles/images/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="{{ config('app.sdk_url') }}/styles/images/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <script>var SMM = SMM || {}; SMM.app = SMM.app || {};</script>
</head>
<body class="SMM-skin bg-light">

<div id="smm_scockpit--topbar" style="position:relative;z-index:2;">
    <header>
        <nav class="navbar navbar-toggleable-md navbar-expand-lg py-2 px-3 bg-primary shadow">
            <a class="navbar-brand">
                <img src="{{ config('app.sdk_url') }}/media/image/logo-s-marktundmehrwert_weiss.png" alt="S-Markt & Mehrwert" style="max-height: 32px">
            </a>
        </nav>
    </header>
</div>

<div id="smm_scockpit--main" style="position:relative;z-index:1;">
    <div id="smm_app--control" class="sticky-top bg-dark shadow">
        <nav class="navbar navbar-expand-md" role="navigation" aria-live="assertive">
            <a  href="https://s-cockpit.de" class="navbar-brand navbar-brand-application px-3 py-2">
                <b>DMC-Cockpit</b>
            </a>

            <ul class="navbar-nav mr-auto w-100">
                @can('main_menu_home')
                    <li class="nav-item px-4">
                        <a href="{{ route('backend.dashboard.index') }}" class="nav-link text-white">
                            <i class="far fa-home pe-2"></i>Dashboard
                        </a>
                    </li>
                @endcan

                @can('main_menu_customers')
                    <li class="nav-item px-3">
                        @role('Administrator')
                        <a href="{{ route('backend.customers.index') }}" class="nav-link text-white">
                            <i class="far fa-university pe-2"></i>Sparkassen
                        </a>
                        @else
                            <a href="{{ route('backend.customers.{customer}.show', \Illuminate\Support\Facades\Auth::user()->customer) }}" class="nav-link text-white">
                                <i class="far fa-university pe-2"></i>Meine Sparkasse
                            </a>
                            @endrole
                    </li>
                @endcan

                @can('main_menu_contacts')
                    <li class="nav-item px-3">
                        <a href="{{ route('backend.contacts.index') }}" class="nav-link text-white">
                            <i class="far fa-address-book pe-2" aria-hidden="true"></i>Kontakte
                        </a>
                    </li>
                @endcan

                @can('main_menu_persons')
                    <li class="nav-item px-3">
                        <a href="{{ route('backend.users.index') }}" class="nav-link text-white">
                            <i class="far fa-users pe-2" aria-hidden="true"></i>Personen
                        </a>
                    </li>
                @endcan

                @can('main_menu_measures')
                    <li class="nav-item px-3">
                        <a href="{{ route('backend.measures.index') }}" class="nav-link text-white">
                            <i class="far fa-handshake pe-2"></i>Maßnahmen
                        </a>
                    </li>
                @endcan

                @can('main_menu_evaluation')
                    <li class="nav-item px-3">
                        <a href="#" class="nav-link text-white">
                            <i class="fa-solid far fa-project-diagram pe-2"></i>Auswertungen
                        </a>
                    </li>
                @endcan

                @can('main_menu_measures')
                    <li class="nav-item px-3">
                        <a href="{{ route('backend.campaigns.index') }}" class="nav-link text-white">
                            <i class="far fa-calendar pe-2"></i>Wettbewerbe
                        </a>
                    </li>
                @endcan
            </ul>

            @if(session('impersonated_by'))
                <div class="d-flex">
                    <a href="{{ route('backend.users.{user}.leave-impersonate', \Auth::user()) }}" class="btn btn-primary text-white"><i class="me-2 far fa-exclamation-triangle" aria-hidden="true"></i>Sitzungsübernahme beenden</a>
                </div>
            @endif
            @if(!session('impersonated_by'))
                <div class="d-flex">
                    <a href="{{ route('logout', \Auth::user()) }}" class="nav-link text-white px-3 d-flex">
                        <i class="fa-regular fa-user me-2 pt-2"></i>Logout
                    </a>
                </div>
            @endif

        </nav>
    </div>
    <div id="smm_app--main">
        <div class="py-3 px-2 min-vh-100">
            @yield('content')
        </div>
    </div>
</div>
<div id="smm_scockpit--bottombar">
    <footer>
        <div class="legal-links py-2">
            <nav class="text-center text-white">
                <a href="{{ route('shared.privacy') }}" target="_blank" class="text-white text-decoration-none">Datenschutz</a> |
                <a href="https://jetztallesmoeglich.de/frontend/impressum" target="_blank" class="text-white text-decoration-none">Impressum</a>
            </nav>
        </div>
        <div class="property-statement py-2">
            <aside class="text-center text-light">
                <span>&copy; <?php echo date('Y'); ?> S-Markt & Mehrwert GmbH & Co. KG. Alle Rechte vorbehalten.</span>
            </aside>
        </div>
    </footer>
</div>
<div class="modal fade bottom" id="smm_scockpit--app-navigation-modal" tabindex="-1" role="dialog" aria-labelledby="smm_scockpit--app-navigation" aria-hidden="true">
    <div class="modal-dialog modal-full-height modal-bottom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100" id="smm_scockpit--app-navigation">Anwendungen</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <nav role="navigation">
                    <ul class="tile-container"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>

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
