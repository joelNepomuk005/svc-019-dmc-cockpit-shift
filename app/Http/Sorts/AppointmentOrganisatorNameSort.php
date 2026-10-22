<?php


namespace App\Http\Sorts;


use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


class AppointmentOrganisatorNameSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {

           $direction = $descending ? 'DESC' : 'ASC';

        $query->orderBy(
            User::select('name')
                ->whereColumn('appointments.organisator_id', 'users.id'),
            $direction
        );

    }
}
