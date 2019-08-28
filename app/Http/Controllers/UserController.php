<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Services\SocialMedia;
use App\Utils\DateRequestFilter;
use App\Utils\Email;
use App\Utils\Helpers;
use App\Utils\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
use PHPUnit\Framework\Constraint\Exception;
use App\Models\VillageAgent;
use Carbon\Carbon;

class UserController extends BaseController
{
    private $request, $email, $requestPassword, $model, $db;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validate = new Validation();
        $this->helpers = new Helpers();
        $this->model = 'App\Models\\' . $this->request->user;
        $this->db = getenv('DB_DATABASE');
    }
    public function requestAccount()
    {
        try {
            $this->validate->validateAccountRequest($this->request);
            $password = Helpers::generateId();
            $user = $this->model::create($this->request->all()
                + Helpers::requestInfo($password));
            if (!$user) return Helpers::returnError("Could not create user.", 408);
            $this->helpers->sendPassword($password, $this->request->email);
            Helpers::logActivity([
                'email' => $user->email,
                'target_account_name' => $user->account_name,
                'target_email' => $user->email,
            ], 'request a dev. partner account.');
            return Helpers::returnSuccess("", [$this->request->user => $user], 200);
        } catch (Exception $e) {
            return Helpers::returnError("Something went wrong.", 408);
        }
    }
    public function createUser()
    {
        try {
            $this->validate->validateNewAccount($this->request);
            $user = $this->model::create($this->request->all() + ['_id' => Helpers::generateId()]);
            if (!$user) {
                return Helpers::sendError("Could not create user.", 503);
            }
            $this->helpers->sendPassword($this->requestPassword, $this->email);
            return Helpers::returnSuccess("Please check your mail for your login password.", ['offtaker' => $user], 200);
        } catch (Exception $e) {
            return Helpers::sendError("Something went wrong", 503);
        }
    }
    /**
     * Returns twitter account number of followers and tweets
     */
    public function getTwitterReport()
    {
        try {
            $twitterReport = SocialMedia::getTwitterSummary();
            return Helpers::returnSuccess("", ['data' => $twitterReport], 200);
        } catch (\Exception $e) {
            return Helpers::returnError(["Something went wrong", $e->getMessage()], 503);
        }
    }
    /**
     * Returns Youtube report
     */
    public function getYoutubeReport()
    {
        try {
            $youtubeChannelSummary = SocialMedia::getYoutubeSummary();
            $statistics = $youtubeChannelSummary->items[0]->statistics;
            return Helpers::returnSuccess("", ['data' => $statistics], 200);
        } catch (Exception $e) {
            return Helpers::returnError("Something went wrong", 503);
        }
    }
    /**
     * Returns facebook page likes and post shares count
     */
    public function getFacebookReport()
    {
        try {
            $facebookReport = SocialMedia::getFacebookSummary();
            return Helpers::returnSuccess("", ['data' => $facebookReport], 200);
        } catch (Exception $e) {
            return Helpers::returnError("Something went wrong", 503);
        }
    }
    public function getAllActiveUsers()
    {
        $requestArray = DateRequestFilter::getRequestParam($this->request);
        list($start_date, $end_date) = $requestArray;
        try {
            $result = DB::select('SELECT * FROM ' . $this->db . ' WHERE type = "ma" OR type  = "offtaker" OR type="partner"');
            $filterUsers = ActivityLog::select('DISTINCT(email)')
                ->where('activity', '=', 'logged in')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get()->count();
            return Helpers::returnSuccess("", [
                'allUsersCount' => count($result),
                'activeUsersCount' => $filterUsers,
            ], 200);
        } catch (Exception $e) {
            return Helpers::returnError("Something went wrong.", 503);
        }
    }

    public function getActiveMobileUsers()
    {
        $requestArray = DateRequestFilter::getRequestParam($this->request);
        list($start_date, $end_date) = $requestArray;
        try {
            $userResult = DB::select('SELECT * FROM ' . $this->db . ' WHERE type = "account"');
            $countServiceResult = Helpers::getActiveMobileUsers(
                $this->db,
                $start_date,
                $end_date
            );
            return Helpers::returnSuccess("", [
                'allMobileUsersCount'    => count($userResult),
                'activeMobileUsersCount' => count($countServiceResult),
            ], 200);
        } catch (Exception $e) {
            return Helpers::returnError("Something went wrong.", 503);
        }
    }

    private function isInvalidVaData()
    {
        $this->validate->validateVillageAgentData($this->request);
        $phoneNumbers = $duplicatePhoneNumbers = [];
        // Check for duplicate phonenumbers and throw error if any found
        foreach ($this->request->all() as $key => $value) {
            array_push($phoneNumbers, $value['va_phonenumber']);
        }
        foreach (array_count_values($phoneNumbers) as $value => $count) {
            if ($count > 1) $duplicatePhoneNumbers[] = $value;
        }
        return count($duplicatePhoneNumbers) > 0;
    }
    private function getVaFromInput()
    {
        if ($this->isInvalidVaData()) return false;
        $villageAgents = [];
        // create new array from input and set id for each village agent
        foreach ($this->request->all() as $key => $value) {
            $value['vaId'] = Helpers::generateId();
            $value['type'] = 'va';
            $value['created_at'] = $value['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            array_push($villageAgents, $value);
        }
        return $villageAgents;
    }
    public function addVillageAgents()
    {
        try {
            $villageAgents = $this->getVaFromInput();
            if (!$villageAgents)
                return Helpers::returnError("Duplicate phone numbers found in entry. Phone numbers must be unique.", 400);
            return VillageAgent::insert($villageAgents) ?
                Helpers::returnSuccess("Village agents added successfully.", [], 201) : Helpers::returnError("Could not add village agents", 503);
        } catch (Exception $e) {
            return Helpers::returnError("Something went wrong", 503);
        }
    }
}
