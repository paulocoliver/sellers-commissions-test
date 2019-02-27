<?php
namespace App\Http\Controllers;

use App\Repositories\SalesRepository;

/**
 * Class SellerController
 *
 * @package App\Http\Controllers
 * @property SalesRepository $repository
 */
class SalesController extends ApiController
{
    public function __construct(SalesRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        return processRequest (function () {
//            return responseOk ($this->repository->allWithCommissions());
//        });
//    }

}
