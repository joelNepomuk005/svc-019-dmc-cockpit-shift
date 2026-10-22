<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomerContactTypeFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        return  $query->whereHas('customer', function (Builder $query) use ($value) {
            $query->orWhere('type_id', $value);
        });
    }
}
