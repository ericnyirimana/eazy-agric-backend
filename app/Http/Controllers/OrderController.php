<?php

namespace App\Http\Controllers;

use App\Utils\Helpers;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class OrderController extends BaseController
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;

    }

    /**
     * get total new orders
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrders()
    {
        try {
            $order = Helpers::getNewOrders($this->request);
            return Helpers::returnSuccess(200, ['totalNewOrders' => $order[0]['newOrders']], "");


        } catch (\Exception $e) {
            return Helpers::returnError('Could not get orders', 503);
        }
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
