<?php

namespace App\Http\Controllers;

use App\Models\VillageAgent;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Utils\DateRequestFilter;
use App\Models\ActivityLog;
use App\Utils\Validation;
use App\Utils\Helpers;

class ActivityLogController extends Controller
{
    private $request;
    private $email;
    private $requestPassword;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validate = new Validation();
        $this->db = getenv('DB_DATABASE');
    }

    /**
     * get all activities in the log
     *
     */
    public function getActivityLog(Request $request) {
        $activity = ActivityLog::all();
        return Helpers::returnSuccess("", ['activityLog' => $activity], 200);
    }
}
