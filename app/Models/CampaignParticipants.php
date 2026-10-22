<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignParticipants extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'campaign_id','start_date','end_date', 'blz'];

    protected $casts = [
        'name' => 'string',
        'customer_ids' => 'int',
        'campaign_id' => 'int',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
