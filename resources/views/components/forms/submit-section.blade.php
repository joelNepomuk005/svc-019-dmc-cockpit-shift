<div class="w-100 py-3 px-3">
    <div class="border-bottom pb-3">
        <div data-double-submit role="button" class="d-flex w-100">
            <div class="locked d-block w-100 justify-content-center">
                <button type="button" role="button" data-alert="" class="btn d-block btn-link text-black w-100">
                    <i aria-hidden="true" class="me-2 fas fa-lock"></i>Abbrechen?
                </button>
            </div>
            <div role="button" class="unlocked d-none w-100">
                <div class="btn-group d-flex justify-content-center w-100" role="group" aria-label="">
                    <button type="button" role="button" data-submit="link||{{ $cancel }}" class="btn btn-dark px-3">Ja</button>
                    <button type="button" role="button" data-cancel="" class="btn btn-dark px-3">Nein</button>
                    <span class="btn btn-primary flex-grow-3 px-3"><i aria-hidden="true" class="d-inline-block me-2 fa fa-lock-open"></i>Abbrechen</span>
                </div>
            </div>
        </div>
    </div>
    <div class="border-top pt-3">
        <button type="submit" class="btn btn-primary d-block w-100">{{ $label }}</button>
    </div>
</div>
