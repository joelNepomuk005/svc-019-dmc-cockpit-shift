<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class CustomerBudget extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'customer_id', 'amount', 'note', 'user_id', 'measure_id', 'budget_type',
    ];

    protected static $logAttributes = ['*'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function measure(): HasOne
    {
        return $this->hasOne(Measures::class, 'id', 'measure_id');
    }

    public function budgetFormatted()
    {
        return number_format($this->amount, 2, ',', '.');
    }
}
