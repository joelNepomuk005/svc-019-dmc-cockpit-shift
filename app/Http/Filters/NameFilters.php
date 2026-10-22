<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class NameFilters
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        return $query->whereHas('customers', function (Builder $query) use ($value) {
            $query
                ->where('name', 'LIKE','%' . $value . '%')
                ->orWhere('short_name', 'LIKE','%' . $value . '%')
                ->orWhere('city', 'LIKE','%' . $value . '%')
                ->orWhere('blz', 'LIKE','%' . $value . '%')
                ->orWhere('bic', 'LIKE','%' . $value . '%')
            ;
        });
    }
}
