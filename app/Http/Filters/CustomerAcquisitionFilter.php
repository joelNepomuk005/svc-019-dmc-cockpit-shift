<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomerAcquisitionFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereHas('key_account_manager', function (Builder $query) use ($value) {
            $query->where('key_account_manager', $value);
        });
    }
}
