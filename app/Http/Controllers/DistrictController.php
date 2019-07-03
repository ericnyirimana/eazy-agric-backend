<?php

namespace App\Http\Controllers;

use App\Models\Farmer;

class DistrictController extends Controller
{
    /**
     * Get top performing districts
     *
     * @return http response object
     */
    public function getTopDistricts()
    {
        $districts = Farmer::pluck('farmer_district')->toArray();
        $allDistricts = [];
        foreach ($districts as $district) {
            if (array_key_exists($district, $allDistricts)) {
                $allDistricts[$district] = $allDistricts[$district] += 1;
            } else {
                $allDistricts[$district] = 1;
            }
        }
        arsort($allDistricts);
        $topDistricts = array_slice($allDistricts, 0, 4, true);
        return response()->json([
            'success' => true,
            'districtCount' => count($allDistricts),
            'farmerCount' => count($districts),
            'topDistricts' => $topDistricts,
            'allDistricts' => $allDistricts
        ], 200);
    }
}
