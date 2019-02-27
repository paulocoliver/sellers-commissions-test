<?php
namespace App\Http\Controllers;

use App\Repositories\Repository;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\Model;

abstract class ApiController extends BaseController
{
    /** @var Repository */
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return processRequest (function () {
            return responseOk ($this->repository->list(request()->query()));
        });
    }

    /**
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return processRequest (function () use ($id) {
            return responseOk ($this->repository->findOrFail($id));
        });
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return processRequest (function () {
            /** @var Model $model */
            $model = $this->repository->getConnection()->transaction(function () {
                return $this->repository::create(request()->post());
            });
            return responseCreated($this->repository->findOrFail($model->getKey()));
        });
    }


    /**
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        return processRequest (function () use ($id) {
            /** @var Model $model */
            $model = $this->repository->getConnection()->transaction(function () use ($id) {
                $model = $this->repository
                    ->findOrFail($id)
                    ->fill(request()->post());
                $model->save();
                return $model;
            });
            return responseOk($model);
        });
    }

    /**
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return processRequest (function () use ($id) {
            $this->repository->getConnection()->transaction(function () use ($id) {
                $this->repository
                    ->findOrFail($id)
                    ->delete();
            });
            return responseNoContent();
        });
    }
}
