<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class CustomerContact
 */
class CustomerContact extends Model
{
    use LogsActivity, SoftDeletes;

    protected static $logAttributes = ['*'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'user_id', 'user_id_log', 'date', 'customer_id', 'contact_type_id', 'contact_person_id',
    ];

    protected $casts = [
        'date' => 'date',
        'contact_type_id' => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function contact_type(): HasOne
    {

        return $this->hasOne(ContactType::class, 'id', 'contact_type_id');

    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function scopeCustomSearch(Builder $query, $search)
    {
        $query->orWhere('title', 'LIKE', '%'.$search.'%');
    }

    public function scopeDate(Builder $query, $date): Builder
    {
        return $query->whereDate('date', '=', Carbon::parse($date));
    }
}
