<?php
namespace App\Models;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    public static function getTableName($withConnection=false)
    {
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = with(new static);
        $table = $model->getTable ();
        if ($withConnection) {
            $connectionName = $model->getConnectionName ();
            if (empty($connectionName)) {
                $connectionName = config('database.default');
            }
            $table = $connectionName.'.'.$table;
        }
        return $table;
    }
}