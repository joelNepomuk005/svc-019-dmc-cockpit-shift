<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class CustomerClassificationFilter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        return $query->whereHas('classification', function (Builder $query) use ($value) {
            $query
                ->where('name', 'LIKE','%' . $value . '%')
            ;
        });
    }
}
