<?php

namespace App\Models;

use App\Enums\Variables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class CustomerMeasures extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'customer_id', 'measure_id', 'from', 'to', 'incentivization', 'coupon', 'state', 'cashback', 'cashback_unlimited', 'causer_id',
    ];

    protected $casts = [
        'from' => 'date',
        'to' => 'date',
    ];

    protected $appends = ['BadgeInformation'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function measure()
    {
        return $this->hasOne(Measures::class, 'id', 'measure_id');
    }

    public function getBadgeInformationAttribute()
    {
        return '<span class="badge '.Variables::$measuresStates['states'][$this->state]['badge'].' rounded-pill">'.Variables::$measuresStates['states'][$this->state]['name'].'</span>';
    }

    /**
     * @return User|null
     *                   Returns the user who created this measure.
     */
    public function causer(): ?User
    {
        return $this->causer_id > 0 ? User::where('id', $this->causer_id)->first() : null;
    }
}
