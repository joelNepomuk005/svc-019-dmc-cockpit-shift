@if ($errors->has($column))
    <span class="invalid-feedback" role="alert">
        <i class="far fa-exclamation-triangle me-2" aria-hidden="true"></i>{{ $errors->first($column) }}
    </span>
@endif
