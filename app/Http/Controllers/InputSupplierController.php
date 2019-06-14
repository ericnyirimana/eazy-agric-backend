<?php

namespace App\Http\Controllers;

use App\Models\InputSupplier;

class InputSupplierController extends Controller
{
    /**
     * Get all input suppliers
     *
     * @return http response object
     */
    public function getInputSuppliers()
    {
        $result = InputSupplier::all();
        return response()->json([
            'success' => true,
            'count' => count($result),
            'inputSuppliers' => $result,
        ], 200);
    }
}
