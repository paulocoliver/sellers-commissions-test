<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 *
 * @package App\Repositories
 * @mixin Model
 *
 * @method static $this create(array $attributes = []) Save a new model and return the instance.
 * @method static $this find($id, $columns = ['*']) Find a model by its primary key or throw an exception.
 * @method static $this findOrFail($id, $columns = ['*']) Find a model by its primary key or throw an exception.
 */
abstract class Repository
{
    /** @var Model */
    protected static $model;


    public function list(array $parameters)
    {
        return $this->all();
    }

    /**
     * @param $method
     * @param $attrs
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $attrs)
    {
        return call_user_func_array([static::getModel(), $method], $attrs);
    }

    /**
     * @param $method
     * @param $attrs
     * @return mixed
     * @throws \Exception
     */
    public static function __callStatic($method, $attrs)
    {
        return call_user_func_array([static::getModel(), $method], $attrs);
    }

    public static function setModel(Model $model)
    {
        static::$model = $model;
    }

    /**
     * @return Model
     */
    public static function getModel()
    {
        if (empty(static::$model)) {
            preg_match('/App\\\Repositories\\\(.+)Repository/', static::class, $result);
            $pathModel = '\App\Models\\';
            if (!empty($result[1]) && class_exists($pathModel.$result[1])) {
                $class = $pathModel.$result[1];
                static::setModel(new $class);
            } else {
                throw new \Exception('Model Not Found');
            }
        }
        return static::$model;
    }
}