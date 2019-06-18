<?php

namespace App\Http\Controllers;

use App\Models\DevtPartner;

class DevtPartnerController extends Controller
{
    /**
     * Get all development partners
     *
     * @return http response object
     */
    public function getDevtPartners()
    {
        $result = DevtPartner::all();
        return response()->json([
            'success' => true,
            'count' => count($result),
            'devtPartners' => $result,
        ], 200);
    }
}
