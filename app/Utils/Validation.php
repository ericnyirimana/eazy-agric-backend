<?php
namespace App\Utils;

use App\Rules\AdminRole;
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
}
