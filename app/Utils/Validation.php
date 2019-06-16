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
    public function validateOfftaker($data)
    {
        $this->validate($data, [
            'email' => 'required|email|unique:offtaker',
            'password' => 'required|min:6',
            'ot_username' => 'required',
            'ot_name' => 'required',
            'ot_account_type' => ['required', new AccountType()],
            'ot_contact_person' => 'required',
            'ot_phonenumber' => 'required',
            'ot_district' => 'required',
            'ot_address' => 'required',
            'ot_valuechain' => ['required', new ValueChain()],
        ]);
    }
    public function validateMasterAgent($data)
    {
        $this->validate($data, [
            'email' => 'required|email|unique:ma',
            'password' => 'required|min:6',
            'ma_account_type' => ['required', new AccountType()],
            'ma_name' => 'required',
            'ma_manager_name' => 'required',
            'ma_phonenumber' => 'required',
            'ma_username' => 'required',
            'ma_district' => 'required',
            'ma_address' => 'required',
            'ma_valuechain' => ['required', new ValueChain()],
        ]);
    }
}
