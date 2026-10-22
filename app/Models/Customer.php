<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Customer
 */
class Customer extends Model
{
    use LogsActivity, SoftDeletes;

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

    public function scopeBic(Builder $query, string $bic)
    {
        $query->where('bic', '=', $bic);
    }

    public function scopeCustomSearch(Builder $query, string $search)
    {
        $query
            ->where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('blz', 'LIKE', '%'.$search.'%')
            ->orWhere('bic', 'LIKE', '%'.$search.'%');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'customer_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(CustomerContact::class, 'customer_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function association(): HasOne
    {
        return $this->hasOne(CustomerAssociation::class, 'id', 'association_id');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function measures(): HasMany
    {
        return $this->hasMany(CustomerMeasures::class, 'customer_id');
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(CustomerBudget::class, 'customer_id');
    }

    public function sumBudgets()
    {
        return number_format(CustomerBudget::where('customer_id', $this->id)->where('budget_type', 'budget')->sum('amount'), 2, ',', '.');
    }

    public function sumPositiveBudgets()
    {
        return number_format(CustomerBudget::where('customer_id', $this->id)->where('amount', '>', 0)->where('budget_type', 'budget')->sum('amount'), 2, ',', '.');
    }

    public function sumPositiveBudgetsDiagramm()
    {
        return number_format(CustomerBudget::where('customer_id', $this->id)->where('amount', '>', 0)->where('budget_type', 'budget')->sum('amount'), 0, '', '');
    }

    public function sumNegativeBudgetsDiagramm()
    {
        return number_format(str_replace('-', '', CustomerBudget::where('customer_id', $this->id)->where('amount', '<', 0)->where('budget_type', 'budget')->sum('amount')), 0, '', '');
    }

    public function sumNegativeBudgets()
    {
        return number_format(str_replace('-', '', CustomerBudget::where('customer_id', $this->id)->where('amount', '<', 0)->where('budget_type', 'budget')->sum('amount')), 2, ',', '.');
    }

    public function sumAssetBudgets()
    {
        return number_format(CustomerBudget::where('customer_id', $this->id)->where('budget_type', 'asset')->sum('amount'), 2, ',', '.');
    }

    public function sumAssetPositiveBudgets()
    {
        return number_format(CustomerBudget::where('customer_id', $this->id)->where('amount', '>', 0)->where('budget_type', 'asset')->sum('amount'), 2, ',', '.');
    }

    public function sumAssetNegativeBudgets()
    {
        return number_format(str_replace('-', '', CustomerBudget::where('customer_id', $this->id)->where('amount', '<', 0)->where('budget_type', 'asset')->sum('amount')), 2, ',', '.');
    }
}
