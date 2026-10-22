<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Customer
 * @package App
 */
class Customer extends Model
{
    use LogsActivity, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected static $logAttributes = ['*'];

    /**
     * @var bool
     */
    protected static $logFillable = true;

    /**
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $fillable = ['id', 'blz', 'bic', 'name', 'long_name', 'short_name', 'location', 'internal_number', 'logo', 'group', 'contact_user', 'association_id', 'business_data', 'key_account_manager', 'association_area_id', 'type_id', 'classification_id',
        'communcation_channels', 'customer_platforms', 'is_customer', 'internal_contact_persons', 'business_volume', 'balance', 'classification_name', 'mandant_id'];

    /**
     * @var array
     */
    protected $casts = ['contact_user' => 'array', 'business_data' => 'array', 'internal_contact_persons' => 'json', 'communcation_channels' => 'json', 'customer_platforms' => 'json'];

    /**
     * @param Builder $query
     * @param string $bic
     */
    public function scopeBic(Builder $query, string $bic)
    {
        $query->where('bic', '=', $bic);
    }

    /**
     * @param Builder $query
     * @param string $search
     */
    public function scopeCustomSearch(Builder $query, $search)
    {
        $query
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('blz', 'LIKE', '%' . $search . '%')
            ->orWhere('bic', 'LIKE', '%' . $search . '%')
        ;
    }

    public function users()
    {
        return $this->hasMany(User::class, 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(CustomerContact::class, 'customer_id', 'id')->orderBy('created_at', 'DESC');;
    }

    public function association () {
        return $this->hasOne(CustomerAssociation::class, 'id', 'association_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function measures () {
        return $this->hasMany(CustomerMeasures::class, 'customer_id');
    }

    public function budgets () {
        return $this->hasMany(CustomerBudget::class, 'customer_id');
    }

    public function sumBudgets () {
        return number_format(CustomerBudget::where('customer_id', $this->id)->where('budget_type', 'budget')->sum('amount'), 2, ',', '.');
    }

    public function sumPositiveBudgets () {
        return number_format(CustomerBudget::where('customer_id', $this->id)->where('amount', '>', 0)->where('budget_type', 'budget')->sum('amount'), 2, ',', '.');
    }
    public function sumPositiveBudgetsDiagramm () {
        return number_format(CustomerBudget::where('customer_id', $this->id)->where('amount', '>', 0)->where('budget_type', 'budget')->sum('amount'), 0, '', '');
    }
    public function sumNegativeBudgetsDiagramm () {
        return number_format(str_replace('-', '', CustomerBudget::where('customer_id', $this->id)->where('amount', '<', 0)->where('budget_type', 'budget')->sum('amount')), 0, '', '');
    }

    public function sumNegativeBudgets () {
        return number_format(str_replace('-', '', CustomerBudget::where('customer_id', $this->id)->where('amount', '<', 0)->where('budget_type', 'budget')->sum('amount')), 2, ',', '.');
    }

    public function sumAssetBudgets () {
        return number_format(CustomerBudget::where('customer_id', $this->id)->where('budget_type', 'asset')->sum('amount'), 2, ',', '.');
    }

    public function sumAssetPositiveBudgets () {
        return number_format(CustomerBudget::where('customer_id', $this->id)->where('amount', '>', 0)->where('budget_type', 'asset')->sum('amount'), 2, ',', '.');
    }

    public function sumAssetNegativeBudgets () {
        return number_format(str_replace('-', '', CustomerBudget::where('customer_id', $this->id)->where('amount', '<', 0)->where('budget_type', 'asset')->sum('amount')), 2, ',', '.');
    }
}
