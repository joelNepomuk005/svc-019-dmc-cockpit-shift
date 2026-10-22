<?php


namespace App\Http\Filters;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DashboardAquisitionsDateFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {

        if($value) {

            $date = explode(" - ", $value);

            if(is_null($date[1])) {
                return $query->whereDate('done_until', '=', Carbon::parse($date[0]));
            } else {
                return $query->whereBetween('done_until', [Carbon::parse($date[0])->startOfDay(),Carbon::parse($date[1])->endOfDay()]);
            }

        }
        else {
            return $query;
        }

    }


}
