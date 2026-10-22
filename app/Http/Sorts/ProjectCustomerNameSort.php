<?php


namespace App\Http\Sorts;


use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;


class ProjectCustomerNameSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {

           $direction = $descending ? 'DESC' : 'ASC';

        $query->orderBy(Customer::select('name')->whereColumn('customer_projects.customer_id', 'customers.id'), $direction);


    }
}
