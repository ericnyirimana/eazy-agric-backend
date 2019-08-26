<?php
namespace App\Utils;

use App\Rules\AccountType;
use App\Rules\AdminRole;
use App\Rules\District;
use App\Rules\Email;
use App\Rules\emailUpdate;
use App\Rules\ValueChain;
use App\Rules\PhoneNumber;
use Laravel\Lumen\Routing\Controller as BaseController;

class Validation extends BaseController
{
    private $email;
    public function validateAdmin($data)
    {
        $this->validate($data, [
            'firstname' => 'required|regex:/^([a-zA-z\s\-\(\)]*)$/',
            'lastname' => 'required|regex:/^([a-zA-z\s\-\(\)]*)$/',
            'email' => ['required', 'email', new Email($data['email'])],
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
            'address' => 'required|regex:/^([a-zA-z\s\-\(\)]*)$/',
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
    public function validateExistingAccount($data, $id)
    {
        $this->validate($data, [
            'email' => ['email', new emailUpdate($data['email'], $id)],
            'account_type' => [new AccountType()],
            'firstname' => 'regex:/^([a-zA-z\s\-\(\)]*)$/',
            'lastname' => 'regex:/^([a-zA-Z\s\-\(\)]*)$/',
            'contact_person' => 'regex:/^([a-zA-z\s\-\+\(\)]*)$/',
            'phonenumber' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:17',
            'district' => [new District()],
            'address' => 'regex:/^([a-zA-z0-9\s\,\(\)]*)$/',
            'value_chain' => [new ValueChain()],
            'adminRole' => [new AdminRole()],
        ]);
    }
    public function validateVillageAgentData($data) {
      $this->validate($data, [
        '*.va_gender' => 'required',
        '*.va_region' => 'required',
        '*.va_subcounty' => 'required',
        '*.va_phonenumber' => ['required', new PhoneNumber()],
        '*.va_district' => [new District()]
      ]);
    }

    public function validateLimitAndOffset($data)
    {
        $this->validate($data, [
            'offset' => 'numeric',
            'limit' => 'numeric',
        ]);
    }
}
