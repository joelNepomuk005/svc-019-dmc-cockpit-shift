<?php


namespace App\Http\Sorts;


use App\Models\Customer;
use App\Models\CustomerBudget;
use Illuminate\Database\Eloquent\Builder;


class CustomerBudgetSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        $query->addSelect(['budget_amount' => CustomerBudget::selectRaw('sum(amount) as budget_amounts')
            ->whereColumn('customer_id', 'customers.id')
        ])->orderBy('budget_amount', $direction);


    }
}
