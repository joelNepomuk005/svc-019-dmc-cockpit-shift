<?php

namespace App\Models;

use App\Enums\Variables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Measures extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected static $logAttributes = ['*'];

    protected $fillable = [
        'name', 'from', 'to', 'customer_ids', 'file_ids',
    ];

    protected $casts = [
        'from' => 'date',
        'customer_ids' => 'array',
        'to' => 'date',
    ];

    public function customerMeasures()
    {
        return $this->hasMany(CustomerMeasures::class, 'measure_id');
    }

    public function customer($id)
    {
        return Customer::where('id', $id)->first();
    }

    public function promotionPackage()
    {
        return File::where('measure_id', $this->id)->where('is_promotion_package', 1)->first();
    }

    public function measureImage()
    {
        return File::where('measure_id', $this->id)->where('is_measure_image', 1)->first();
    }

    public function customerMeasure($customer_id)
    {
        return CustomerMeasures::where('measure_id', $this->id)->where('customer_id', $customer_id)->first();
    }

    public function customerIncentivization()
    {
        return $this->hasMany(CustomerMeasures::class, 'measure_id')->where('incentivization', 1);
    }

    public function customerCoupons()
    {
        return $this->hasMany(CustomerMeasures::class, 'measure_id')->where('coupon', 1);
    }

    public function isActiveMeasure($customer_id)
    {
        return CustomerMeasures::where('customer_id', $customer_id)->where('measure_id', $this->id)->first();
    }

    public function getBadgeInformation($customer_id)
    {
        if (! empty(Variables::$measuresStates['states'][$this->isActiveMeasure($customer_id)->state]['badge'])) {
            return '<span class="badge '.Variables::$measuresStates['states'][$this->isActiveMeasure($customer_id)->state]['badge'].' rounded-pill">'.Variables::$measuresStates['states'][$this->isActiveMeasure($customer_id)->state]['name'].'</span>';
        } else {
            $label = $this->upcomingOrRunning($customer_id) ? 'offen' : 'abgelaufen';

            return '<span class="badge bg-warning rounded-pill">'.$label.'</span>';
        }
    }

    public function getMeasureState($customer_id)
    {
        if (! empty(Variables::$measuresStates['states'][$this->isActiveMeasure($customer_id)->state]['badge'])) {
            return Variables::$measuresStates['states'][$this->isActiveMeasure($customer_id)->state]['name'];
        } else {
            return 'offen';
        }
    }

    public function upcomingOrRunning($customer_id)
    {
        $measure = $this->isActiveMeasure($customer_id);

        if ($this->to > now()) {
            return true; // Measure is upcoming or running
        }

        return false;
    }

    public function excelExportMeasureState($customer_id)
    {
        if (! empty(Variables::$measuresStates['states'][$this->isActiveMeasure($customer_id)->state]['badge'])) {
            return Variables::$measuresStates['states'][$this->isActiveMeasure($customer_id)->state]['name'];
        } else {
            return 'offen';
        }
    }
}
