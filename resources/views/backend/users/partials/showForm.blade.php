<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="showContactLabel">Person anzeigen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="container pl-0 pr-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="pe-2">
                        <dl class="row">
                            <dt class="col-6">S-Cockpit User:</dt>
                            <dd class="col-6">@if (!empty($user->scockpit_user_id)) <span><i class="fa fa-check text-success"></i></span> @else <span><i class="fa fa-times text-danger"></i></span> @endif</dd>
                            <dt class="col-6">Sparkasse:</dt>
                            <dd class="col-6">{{ $user->customer->name }}</dd>
                            <dt class="col-6">Anrede:</dt>
                            <dd class="col-6">@if ($user->salutation == 'male') Herr @elseif ($user->salutation == 'female') Frau @else Divers @endif</dd>
                            <dt class="col-6">Vorname:</dt>
                            <dd class="col-6">{{ $user->first_name }}</dd>
                            <dt class="col-6">Nachname:</dt>
                            <dd class="col-6">{{ $user->last_name }}</dd>
                            <dt class="col-6">E-Mail:</dt>
                            <dd class="col-6">{{ $user->email }}</dd>
                            <dt class="col-6">Telefon:</dt>
                            <dd class="col-6">{{ $user->phone }}</dd>
                            <dt class="col-6">Rolle:</dt>
                            <dd class="col-6">{{ $user->userCategories->name }}</dd>
                            <dt class="col-6">Berufsbezeichnung:</dt>
                            <dd class="col-6">{{ $user->job_title }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Schließen</button>
    </div>
</div>