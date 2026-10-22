@can('home_view_search')
<div class="col ms-auto">
    <div class="">
        <form>
            <div class="form-group">
                <select name="quicklinks[management_participants]" id="quicklinks_management_participants" class="selectpicker w-100 btn-block" multiple title="Sparkasse zur Verwaltung wählen" data-live-search="true" data-done-button="true" data-done-button-text="Schließen" onchange="location = this.value">
                    @foreach(\App\Models\Customer::all() as $customer)
                        <option value="{{ route('backend.customers.{customer}.show', $customer->id) }}" data-subtext="{{ $customer->blz }}" data-tokens="{{ $customer->name }} {{ $customer->blz }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>
@endcan