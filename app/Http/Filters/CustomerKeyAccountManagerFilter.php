<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomerKeyAccountManagerFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('customer', function (Builder $query) use ($value) {
            $query
                ->whereIn('key_account_manager', $value)
            ;
        });
    }
}
