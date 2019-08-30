<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

use App\Utils\Helpers;

class OrderController extends BaseController
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
     }

    /**
     * GET /orders/completed
     *
     * @return object HTTP response
     */

    public function getCompletedOrders()
    {
        $response = Helpers::getCompletedOrders();
        return $response;
    }
}
