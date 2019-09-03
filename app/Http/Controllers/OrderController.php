<?php

namespace App\Http\Controllers;

use App\Models\InputSupplier;
use App\Utils\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * Route - GET /orders/{type}
     *
     * @return object HTTP response
     */

    public function getOrdersByType($type)
    {
        try {
            $response = Helpers::getOrdersByType($type);
        } catch (\Exception $e) {
            $response = Helpers::returnError('Could not get orders', 503);
        }
        return $response;
    }

    /**
     * GET available stock
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInputsStock()
    {
        try {

            $stock = [];
            $inputs = InputSupplier::select(
                'category', DB::raw('SUM(quantity) as quantity'))->groupBy('category')->get();

            for ($i = 0; $i < count($inputs); $i++) {
                $stock += [$inputs[$i]["category"] => $inputs[$i]["quantity"]];
            }

            return Helpers::returnSuccess(200, [
                "available_stock" => $stock,
                "total" => array_sum($stock),
            ], "");

        } catch (\Exception $e) {

            return Helpers::returnError("Could not get input stock.", 503);

        }

    }
}
