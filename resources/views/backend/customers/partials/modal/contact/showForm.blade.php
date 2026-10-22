<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="showContactLabel">Kontakt anzeigen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="container pl-0 pr-0">
            <div class="row">
                <div class="col-12">
                    <div class="pe-2">
                        <dl class="row">
                            <dt class="col-6">Sparkasse:</dt>
                            <dd class="col-6">{{ $customerContact->customer->name }}</dd>
                            <dt class="col-6">Datum:</dt>
                            <dd class="col-6">{{ $customerContact->date->format('d.m.Y') }}</dd>
                            <dt class="col-6">Erfasser:</dt>
                            <dd class="col-6">{{ $customerContact->user->name }}</dd>
                            <dt class="col-6">Betreff:</dt>
                            <dd class="col-6">{{ $customerContact->title }}</dd>
                            <dt class="col-6">Kontaktart:</dt>
                            <dd class="col-6">{{ $customerContact->contact_type->name }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Schließen</button>
    </div>
</div>