<?php

namespace App\Http\Sorts;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class AcquisitionCustomerOrganisatorSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {

        $direction = $descending ? 'DESC' : 'ASC';

        $query->orderBy(
            User::select('name')
                ->whereColumn('customer_acquisitions.customer_id', 'customers.id'),
            $direction
        );

        return $query->join('users', 'users.id', '=', 'organisator_id')
            ->orderBy('users.name', $direction);

    }
}
