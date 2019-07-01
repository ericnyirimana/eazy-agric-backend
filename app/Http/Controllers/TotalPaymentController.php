<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Order;
use App\Models\MapCordinates;
use App\Models\SoilTest;
use App\Models\Planting;
use App\Models\Spraying;


class TotalPaymentController extends Controller
{
    /**
     * Get total payment made by farmers of EzyAgric
     *
     * @return http response object
     */
    public function getTotalPayment()
    {
        try{
            $sumMapCordinate = MapCordinates::all()->sum('acreage');
            $sumOrder = Order::all()->sum('details.totalCost');
            $sumSoilTest = SoilTest::all()->sum('total');
            $sumPlanting = Planting::all()->sum('total');
            $sumSpraying = Spraying::all()->sum('total');
            $sumTotalPayment = ($sumMapCordinate + $sumOrder + $sumSoilTest + $sumPlanting + $sumSpraying);
            return response()->json([
                'success' => true,
                'totalPayment' => $sumTotalPayment
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.'], 503);
        }
       
    }
}
