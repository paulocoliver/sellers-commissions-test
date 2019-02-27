<?php
namespace App\Repositories;

use \Carbon\Carbon;

class SalesRepository extends Repository
{
    public function list(array $parameters) {

        $query = static::query();

        if (!empty($parameters['seller_id'])) {
            $query->where('seller_id', (int) $parameters['seller_id']);
        }

        return $query->get();
    }

    public function getTotalByDay(Carbon $date) {
        return static::query()
            ->whereDate('created_at', '>=', $date->startOfDay())
            ->whereDate('created_at', '<=', $date->endOfDay())
            ->sum('amount');
    }
}