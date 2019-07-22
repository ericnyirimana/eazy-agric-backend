<?php
namespace App\Http\Controllers;

use App\Models\OffTaker;
use App\Utils\Email;
use App\Utils\Helpers;
use App\Utils\Validation;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Carbon\Carbon;
use App\Utils\DateRequestFilter;

class OfftakerController extends BaseController
{
    private $request;
    private $userData;
    private $email;
    private $url;
    private $requestPassword;
    private $password;
    private $mail;
    private $message;
    /**
     * Offtaker constructor
     * @param object http request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validate = new Validation();
        $this->email = $this->request->input('email');
        $this->requestPassword = $this->request->input('password');
        $this->url = getenv('FRONTEND_URL');
        $this->mail = new Email();
        $this->helpers = new Helpers();
    }
}
