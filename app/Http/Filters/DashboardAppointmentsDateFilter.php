<?php


namespace App\Http\Filters;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DashboardAppointmentsDateFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {


        if($value) {

            $date = explode(" - ", $value);

            if(is_null($date[1])) {
                return $query->whereDate('planned_start', '=', Carbon::parse($date[0]));
            } else {
                return $query->whereBetween('planned_start', [Carbon::parse($date[0])->startOfDay(),Carbon::parse($date[1])->endOfDay()]);
            }

        }
        else {
            $value = Carbon::now()->startOfDay() . ' - ' .Carbon::now()->addYear(1)->endOfDay();

            $date = explode(" - ", $value);

            return $query->whereBetween('planned_start', [$date[0], $date[1]]);
        }


    }
}
