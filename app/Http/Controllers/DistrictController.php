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
        $districtsFarmerCount = [];
        foreach ($districts as $district) {
            if (array_key_exists($district, $districtsFarmerCount)) {
                $districtsFarmerCount[$district] = $districtsFarmerCount[$district] += 1;
            } else {
                $districtsFarmerCount[$district] = 1;
            }
        }
        arsort($districtsFarmerCount);
        $districtsFarmerCount = array_slice($districtsFarmerCount, 0, 4, true);
        return response()->json([
            'success' => true,
            'count' => count($districts),
            'topDistricts' => $districtsFarmerCount,
        ], 200);
    }
}
