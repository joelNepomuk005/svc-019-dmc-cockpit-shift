<div class="row">
    <div class="col-12">
        <div class="row mb-3">
            <div class="col-6">
                <header>
                    <h3 class="h5">Angaben zur Sparkasse</h3>
                </header>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <dl class="row highlight-dd">
            <dt class="col-5">Institutsname</dt>
            <dd class="col-7">{{ $customer->name }}</dd>
            <dt class="col-5">Verband</dt>
            <dd class="col-7">{{ !empty($customer->association) ? $customer->association->short_name : '- keine Angabe -' }}</dd>
            <dt class="col-5">Bankleitzahl</dt>
            <dd class="col-7">{{ $customer->blz }}</dd>
            <dt class="col-5">BIC</dt>
            <dd class="col-7">{{ $customer->bic }}</dd>
        </dl>
    </div>
</div>