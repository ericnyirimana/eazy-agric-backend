<?php
namespace App\Utils;

use Illuminate\Http\Request;

use Carbon\Carbon;


class DateRequestFilter {

    private $percentage;
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

    /**
     * generate a percentage increase or decrease from start date filtered count and end date filtered count 
     * usingthe Parameters Supplied
     * all params are required
     */
    public static function getPercentage($startDateCount, $endDateCount)
    {
        if($startDateCount !== null && $endDateCount !== null){ 
            if($startDateCount === 0 && $endDateCount === 0){
                $percentage = 0;
            } else {
                $percentage = $startDateCount > 0 ? ((($endDateCount - $startDateCount)/$startDateCount) * 100) : 100;
            }
            return $percentage;
        }
            return 0;
    }

}
