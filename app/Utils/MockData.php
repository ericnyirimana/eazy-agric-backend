<?php
namespace App\Utils;

use Crisu83\ShortId\ShortId;

class MockData
{
    protected $adminData = ['email' => 'someone@gmail.com', 'password' => '123456'];
    protected $loginDetails = ['email' => 'admin1234@gmail.com', 'password' => 'admin1234'];
    protected $masterAgentData = ['email' => 'masteragent1234@gmail.com', 'password' => 'masteragent1234'];
    protected $passwordMismatchData = [
        'password' => 'admin12346',
        'confirmPassword' => 'admin12345',
        'adminRole' => 'Analyst',
    ];
    protected $newAdmin = [
        'password' => 'admin12345',
        'confirmPassword' => 'admin12345',
        'adminRole' => 'Analyst',
    ];

    public $shortid;
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->shortid = ShortId::create();

        $this->passwordMismatchData = [
            'email' => $this->shortid->generate() . '@gmail.com',
            'password' => 'admin12346',
            'confirmPassword' => 'admin12345',
            'adminRole' => 'Analyst',
        ];

    }
    public function getAdminData()
    {
        return $this->adminData;
    }
    public function getLoginDetails()
    {
        return $this->loginDetails;
    }
    public function getMasterAgentData()
    {
        return $this->masterAgentData;
    }
    public function getPasswordMismatchData()
    {
        $this->passwordMismatchData['email'] = $this->shortid->generate() . '@gmail.com';
        return $this->passwordMismatchData;
    }
    public function getNewAdmin()
    {
        $this->newAdmin['email'] = $this->shortid->generate() . '@gmail.com';
        return $this->newAdmin;
    }
}
