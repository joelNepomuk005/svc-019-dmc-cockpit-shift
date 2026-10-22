<?php


namespace App\Http\Filters;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomerAppointmentPerYearSpecificationFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        return $query->whereBetween('planned_start', [Carbon::now()->startOfYear(), Carbon::today()]);
    }
}
