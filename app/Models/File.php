<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['name', 'description', 'checksum', 'path', 'measure_id', 'file_type','is_promotion_package', 'is_measure_image', 'is_campaign_image'];

    public function fileable()
    {
        return $this->morphTo();
    }
}
