<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomerAcquisitionProductCategoryFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereHas('products', function (Builder $query) use ($value) {
            $query->where('category_id', '=', $value);
        });
    }
}
