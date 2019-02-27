<?php
namespace App\Http\Controllers;

use App\Repositories\SellerRepository;

/**
 * Class SellerController
 *
 * @package App\Http\Controllers
 * @property SellerRepository $repository
 */
class SellerController extends ApiController
{
    public function __construct(SellerRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return processRequest (function () {
            return responseOk ($this->repository->allWithCommissions(request('q')));
        });
    }

}
