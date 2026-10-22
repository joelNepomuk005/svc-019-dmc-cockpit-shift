<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomerStateFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {

        return $query->whereHas('measures', function (Builder $query) use ($value) {
            $query->where('state', $value);
        });

    }
}
