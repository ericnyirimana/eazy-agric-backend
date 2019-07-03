<?php
namespace App\Utils;

use Illuminate\Http\Request;

use Carbon\Carbon;


class DateRequestFilter {

    /**
     * generate a start and end date value from the Request object
     * all params are required
     */
    public static function getRequestParam(Request $request)
    {   
        $start_date = $request->input('start_date') ? new Carbon($request->input('start_date')) : '';
        $end_date = $request->input('end_date') ? new Carbon($request->input('end_date')) : Carbon::now();

        return array($start_date, $end_date);
    }

}
