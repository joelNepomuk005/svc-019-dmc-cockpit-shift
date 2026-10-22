<?php

namespace App\Http\Sorts;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

class AcquisitionCustomerLocationSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {

        $direction = $descending ? 'DESC' : 'ASC';

        $query->orderBy(
            Customer::select('location')
                ->whereColumn('customer_acquisitions.customer_id', 'customers.id'),
            $direction
        );

    }
}
