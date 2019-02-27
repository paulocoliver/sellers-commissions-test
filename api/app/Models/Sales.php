<?php
namespace App\Models;

use App\Traits\hasValidation;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Sales
 *
 * @package App\Models
 * @property int id
 * @property int seller_id
 * @property float commission
 * @property float amount
 */
class Sales extends Model
{
    use hasValidation;

    const COMMISSION = 0.085;

    protected $fillable = ['amount', 'seller_id'];

    public $timestamps = true;

    protected static function boot()
    {
        static::creating(function (Sales $model) {
            if ($model->amount > 0) {
                $model->commission = $model->amount * static::COMMISSION;
            }
        });

        static::updating(function () {
            throw new \Exception('Update action is not allowed');
        });

        static::addGlobalScope('seller', function (Builder $builder) {
            $builder->with('seller');
        });

        parent::boot();
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function getValidationRules() {
        return [
            "seller_id" => [
                'required', validatorExists(Seller::getTableName(), 'id')
            ],
            "amount" => [
                'required', 'min:0.01', 'numeric'
            ]
        ];
    }
}
