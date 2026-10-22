<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date', 'images', 'uuid', 'title', 'subheadline', 'link', 'prefix'];

    protected $casts = [
        'name' => 'string',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'images' => 'json',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
