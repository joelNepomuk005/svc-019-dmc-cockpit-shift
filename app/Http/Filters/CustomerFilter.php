<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomerFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereHas('customer', function (Builder $query) use ($value) {
            $query->where('name', 'LIKE', '%' . $value . '%');
        });
    }
}
