<?php
namespace App\Models;

use App\Traits\hasValidation;
use Illuminate\Database\Eloquent\Builder;

class Seller extends Model
{
    use hasValidation;

    protected $fillable = ['name','email'];

    public $timestamps = true;

    protected static function boot()
    {
        static::addGlobalScope('commissions', function (Builder $builder) {

            $subQuery = Sales::query ()
                ->selectRaw ('SUM(sales.commission)')
                ->whereColumn ('sales.seller_id','=', 'sellers.id');

            $builder->select()
                ->selectSub ($subQuery->toSql (), 'commissions');
        });

        static::deleting(function (Seller $seller) {
            $seller->sales()->delete();
        });

        parent::boot();
    }

    public function sales()
    {
        return $this->hasMany(\App\Models\Sales::class);
    }

    public function getValidationRules() {

        $uqEmail = validatorUnique($this->getTable());
        if ($this->exists) {
            $uqEmail->ignore($this->id);
        }

        return [
            "name" => [
                'required',
            ],
            "email" => [
                'required', 'email', $uqEmail
            ]
        ];
    }
}
