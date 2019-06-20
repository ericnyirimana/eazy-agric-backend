<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\MapCordinates;

class MapCordinatesController extends Controller
{
    /**
     * Get total acreage for farmers using ezyagric
     *
     * @return http response object
     */
    public function getTotalAcreage()
    {
        try{
            $result = MapCordinates::all()->sum('acreage');
            return response()->json([
                'success' => true,
                'totalAcreage' => $result
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.'], 503);
        }
       
    }
}
