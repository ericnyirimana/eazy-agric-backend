<?php

namespace App\Http\Controllers;

use App\Models\InputSupplier;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Utils\DateRequestFilter;

class InputSupplierController extends Controller
{
    /**
     * Get all input suppliers
     *
     * @return http response object
     */
    public function getInputSuppliers(Request $request)
    {
        $requestArray = DateRequestFilter::getRequestParam($request);
        list($start_date, $end_date) = $requestArray;

        $result = InputSupplier::whereBetween('created_at', [$start_date, $end_date])->get();
        return response()->json([
            'success' => true,
            'count' => count($result),
            'inputSuppliers' => $result,
        ], 200);
    }
}
