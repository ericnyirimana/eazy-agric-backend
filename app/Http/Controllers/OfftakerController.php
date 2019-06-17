<?php

namespace App\Http\Controllers;

use App\Models\Offtaker;

class OfftakerController extends Controller
{
    /**
     * Get all input suppliers
     *
     * @return http response object
     */
    public function getOfftakers()
    {
        $result = OffTaker::all();
        return response()->json([
            'success' => true,
            'count' => count($result),
            'offtakers' => $result,
        ], 200);
    }
}
