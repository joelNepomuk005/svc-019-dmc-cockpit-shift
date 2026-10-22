<div class="container-fluid mb-3">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                @if (!empty($path))
                    {{ Breadcrumbs::render($path, $model, $primaryModel) }}
                @endif
            </nav>
        </div>
    </div>
</div>
