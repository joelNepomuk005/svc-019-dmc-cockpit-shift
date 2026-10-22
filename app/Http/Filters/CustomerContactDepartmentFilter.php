<?php


namespace App\Http\Filters;


use App\Models\CustomerContact;
use App\Models\CustomerDepartments;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomerContactDepartmentFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {

        $oldDepartmentNames = CustomerDepartments::whereIn('id', $value)->pluck('name');

        foreach ($oldDepartmentNames as $name) {

            $query->orWhere('department', 'LIKE', '%' . $name . '%');
        }

        return $query->orWhereJsonContains('customer_department_id', $value);

    }
}
