<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="showBudgetLabel">Budget anzeigen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="container pl-0 pr-0">
            <div class="row">
                <div class="col-12">
                    <div class="pe-2">
                        <dl class="row">
                            <dt class="col-6">Betrag:</dt>
                            <dd class="col-6">{{ $budget->amount }} €</dd>
                            <dt class="col-6">Notiz:</dt>
                            <dd class="col-6">{{ $budget->note }}</dd>
                            <dt class="col-6">Buchungsdatum:</dt>
                            <dd class="col-6">{{ $budget->created_at->format('d.m.Y') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Schließen</button>
        </div>
    </div>
</div>