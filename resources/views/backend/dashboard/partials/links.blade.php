@can('home_dashboard_links')
    <div class="row mb-5">
        <div class="col-3">
            <div class="card py-3">
                <div class="card-body text-center py-3">
                    <a data-bs-toggle="modal" data-bs-target="#showContactModal" href="{{ route('backend.dashboard.show') }}" data-ajax class="text-decoration-none">
                    <span class="d-inline-block bg-primary rounded p-5">
                        <i class="far fa-4x fa-envelope text-white"></i>
                    </span>
                        <span class="d-block text-black text-decoration-none fs-3">Kontakt</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card py-3">
                <div class="card-body text-center py-3">
                    <a href="{{ route('backend.customers.{customer}.modalTabs', [Auth::user()->customer, 'budgets']) }}" class="text-decoration-none">
                    <span class="d-inline-block bg-primary rounded p-5">
                        <i class="far fa-4x fa-user text-white"></i>
                    </span>
                        <span class="d-block text-black text-decoration-none fs-3">Budget verwalten</span>
                    </a>
                    <hr/>
                    <a href="{{ asset('media/document/2026-06-04_S-MM_DMC-GiveAway_Bestellformular.pdf') }}" class="text-decoration-none" target="_blank">
                        <span class="d-block text-black text-decoration-none fs-3">Werbemittel & Give-aways Bestellformular</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card py-3">
                <div class="card-body text-center py-3">
                    <a href="{{ asset('media/document/jahresuebersicht.pdf') }}" class="text-decoration-none" target="_blank">
                        <span class="d-inline-block bg-primary rounded p-5">
                            <i class="far fa-4x fa-user text-white"></i>
                        </span>
                        <span class="d-block text-black text-decoration-none fs-3">Jahresübersicht</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card py-3">
                <div class="card-body text-center py-3">

                    <a href="{{ asset('media/document/kampagnenbroschuere.pdf') }}" class="text-decoration-none" target="_blank">
                        <span class="d-inline-block bg-primary rounded p-5">
                            <i class="far fa-4x fa-user text-white"></i>
                        </span>
                        <span class="d-block text-black text-decoration-none fs-3">Kampagnenbroschüre</span>
                    </a>
                    <hr/>
                    <a href="{{ asset('media/document/FAQ_Webinar_2026.pdf') }}" class="text-decoration-none" target="_blank">
                        <span class="d-block text-black text-decoration-none fs-3">FAQ Webinar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endcan
