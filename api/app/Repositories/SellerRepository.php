<?php
namespace App\Repositories;

use App\Models\Sales;

class SellerRepository extends Repository
{
    public function allWithCommissions($q=null) {

        $subQuery = Sales::query ()
            ->selectRaw ('SUM(sales.commission)')
            ->whereColumn ('sales.seller_id','=', 'sellers.id');

        $query = static::query()
            ->select()
            ->selectSub ($subQuery->toSql (), 'commissions');

        if (!empty($q)) {
            $query->where('name',  'LIKE', "%$q%")
                ->orWhere('email', 'LIKE', "%$q%");
        }

        return $query->get();
    }
}