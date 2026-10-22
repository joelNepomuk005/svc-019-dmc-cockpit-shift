<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DashboardAppointmentsUserFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
           return $query->whereIn('organisator_id', $value);
    }
}
