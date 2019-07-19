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
            'firstname' => 'required|alpha',
            'lastname' => 'required|alpha',
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
            'firstname' => 'required|regex:/^([a-zA-z\s\-\(\)]*)$/',
            'lastname' => 'required|regex:/^([a-zA-z\s\-\(\)]*)$/',
            'contact_person' => 'required|regex:/^([a-zA-z\s\-\+\(\)]*)$/',
            'phonenumber' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:17',
            'district' => ['required', new District()],
            'address' => 'required|regex:/^([a-zA-z0-9\s\,\(\)]*)$/',
            'value_chain' => ['required', new ValueChain()],
        ]);
    }

    public function validateAccountRequest($data)
    {
        $db = getenv('DB_DATABASE');
        $this->validate($data, [
            'email' => ['required', 'email', new Email($data['email'])],
            'firstname' => 'required|regex:/^([a-zA-z\s\-\(\)]*)$/',
            'lastname' => 'required|regex:/^([a-zA-z\s\-\(\)]*)$/',
            'phonenumber' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:17',
            'organization' => 'required|regex:/^([a-zA-z\s\-\(\)]*)$/',
        ]);
    }

    public function validateContactForm($data)
    {
        $db = getenv('DB_DATABASE');
        $this->validate($data, [
            'email' => 'required|email',
            'name' => 'required||regex:/^([a-zA-z\s\-\+\(\)]*)$/',
            'message' => 'required',
        ]);
    }
    public function validateAdminChangePassword($data)
    {
        $this->validate($data, [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
        ]);
    }
}
