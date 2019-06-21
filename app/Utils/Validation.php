<?php
namespace App\Utils;

use App\Rules\AccountType;
use App\Rules\AdminRole;
use App\Rules\ValueChain;
use Laravel\Lumen\Routing\Controller as BaseController;

class Validation extends BaseController
{
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

    public function validateOfftaker($data)
    {
        $this->validate($data, [
            'email' => 'required|email|unique:offtaker',
            'password' => 'required|min:6',
            'ot_username' => 'required',
            'ot_name' => 'required',
            'account_type' => ['required', new AccountType()],
            'ot_contact_person' => 'required',
            'phonenumber' => 'required',
            'ot_district' => 'required',
            'ot_address' => 'required',
            'value_chain' => ['required', new ValueChain()],
        ]);
    }

    public function validateMasterAgent($data)
    {
        $this->validate($data, [
            'email' => 'required|email|unique:ma',
            'password' => 'required|min:6',
            'account_type' => ['required', new AccountType()],
            'ma_name' => 'required',
            'ma_manager_name' => 'required',
            'phonenumber' => 'required',
            'ma_username' => 'required',
            'ma_district' => 'required',
            'ma_address' => 'required',
            'value_chain' => ['required', new ValueChain()],
        ]);
    }

    public function validateDevtPartner($data)
    {
        $this->validate($data, [
            'email' => 'required|email|unique:ma',
            'password' => 'required|min:6',
            'account_type' => ['required', new AccountType()],
            'dp_name' => 'required',
            'dp_contact_person' => 'required',
            'phonenumber' => 'required',
            'dp_username' => 'required',
            'dp_district' => 'required',
            'dp_address' => 'required',
            'value_chain' => ['required', new ValueChain()],
        ]);
    }

    public function validateAccountRequest($data)
    {
        $this->validate($data, [
            'email' => 'required|email',
            'firstname' => 'required',
            'lastname' => 'required',
            'phonenumber' => 'required',
            'organization' => 'required',

        ]);
    }
}
