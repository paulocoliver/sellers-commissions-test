<?php
namespace App\Repositories;

class SalesRepository extends Repository
{
    public function list(array $parameters) {

        $query = static::query();

        if (!empty($parameters['seller_id'])) {
            $query->where('seller_id', (int) $parameters['seller_id']);
        }

        return $query->get();
    }
}