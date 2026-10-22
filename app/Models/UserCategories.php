<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class UserCategories extends Model
{
    use LogsActivity, SoftDeletes;

    protected static $logAttributes = ['*'];

    /**
     * @var array
     */
    protected $fillable = ['id', 'name', 'deleted_at', 'updated_at', 'created_at'];

    protected $table = 'user_categories';
}
