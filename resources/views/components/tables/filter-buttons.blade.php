<div class="btn-group" role="group" aria-label="Filter" data-filter-buttons>
    @if($extended == true)
        <button class="btn btn-outline-secondary" type="button" data-type="filter-toggle" data-bs-toggle="collapse" data-bs-target="#collapse-filter" aria-expanded="false" aria-controls="collapse-filter"><i class="fal fa-ellipsis-vertical fa-fw" aria-hidden="true"></i><span class="d-md-none ms-2">Erweiterte Filter anzeigen</span></button>
    @endif
    <button class="btn btn-secondary" data-type="filter-submit" type="submit" data-bs-toggle="tooltip" data-bs-title="Filter anwenden"><i class="fal fa-filter-list fa-fw" aria-hidden="true"></i><span class="d-md-none ms-2">Filter anwenden</span></button>
    <a href="#" class="d-none btn btn-outline-secondary text-decoration-none" data-type="filter-reset" data-bs-toggle="tooltip" data-bs-title="Filter zurücksetzen"><i class="fal fa-times fa-fw" aria-hidden="true"></i><span class="d-md-none ms-2">Filter zurücksetzen</span></a>
</div>
