<?php


namespace App\Http\Filters;


use App\Models\CustomerWorkingOn;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomerContactWorkingOnFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {

        $oldTopicNames = CustomerWorkingOn::whereIn('id', $value)->pluck('name');

        foreach ($oldTopicNames as $name) {

            $query->orWhere('working_on', 'LIKE', '%' . $name . '%');
        }
       return $query->orwhereJsonContains('customer_working_on_id', $value);

    }
}
