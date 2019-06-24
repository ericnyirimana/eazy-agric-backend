<?php
namespace App\Utils;

use App\Rules\AccountType;
use App\Rules\AdminRole;
use App\Rules\District;
use App\Rules\Email;
use App\Rules\ValueChain;
use Laravel\Lumen\Routing\Controller as BaseController;

class Validation extends BaseController
{
    private $email;
    public function validateAdmin($data)
    {
        $this->validate($data, [
            'email' => 'required|email|unique:admin',
            'password' => 'required|min:6',
            'confirmPassword' => 'required',
            'adminRole' => ['required', new AdminRole],
        ]);
    }
    public function validateForgotPassword($data)
    {
        $this->validate($data, [
            'email' => 'required|email',
        ]);
    }
    public function validateConfirmPassword($data)
    {
        $this->validate($data, [
            'password' => 'required|min:8',
            'token' => 'required|min:25',
        ]);
    }
    public function validateVerifyPasswordToken($data)
    {
        $this->validate($data, [
            'token' => 'required|min:25',
        ]);
    }
    public function validateLogin($data)
    {
        $this->validate($data, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }
    public function validateNewAccount($data)
    {
        $this->validate($data, [
            'email' => ['required', 'email', new Email($data['email'])],
            'password' => 'required|min:6',
            'account_type' => ['required', new AccountType()],
            'firstname' => 'required',
            'lastname' => 'required',
            'contact_person' => 'required',
            'phonenumber' => 'required',
            'district' => ['required', new District()],
            'address' => 'required',
            'value_chain' => ['required', new ValueChain()],
        ]);
    }

    public function validateAccountRequest($data)
    {
        $db = getenv('DB_DATABASE');
        $this->validate($data, [
            'email' => ['required', 'email', new Email($data['email'])],
            'firstname' => 'required',
            'lastname' => 'required',
            'phonenumber' => 'required',
            'organization' => 'required',
        ]);
    }
}
