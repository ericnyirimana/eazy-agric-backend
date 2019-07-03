<?php
namespace App\Utils;

use Crisu83\ShortId\ShortId;

class MockData
{
    protected $adminData = ['email' => 'someone@gmail.com', 'password' => '123456'];
    protected $wrongEmail = ['email' => 'someone@gmail.com', 'password' => '1234567'];
    protected $wrongPassword = ['email' => 'admin1234@gmail.com', 'password' => '1234567'];
    protected $loginDetails = ['email' => 'admin2020@gmail.com', 'password' => 'admin2020'];
    protected $masterAgentData = ['email' => 'masteragent2121@gmail.com', 'password' => '123123'];
    protected $passwordMismatchData = [
        'password' => 'admin12346',
        'confirmPassword' => 'admin12345',
        'adminRole' => 'Analyst',
        'firstname' => 'maxxy',
        'lastname' => 'max',
    ];
    protected $newAdmin = [
        'password' => 'admin12345',
        'confirmPassword' => 'admin12345',
        'adminRole' => 'Analyst',
        'firstname' => 'maxxy',
        'lastname' => 'max',
    ];
    protected $invalidToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.
    eyJpc3MiOiJsdW1lbi1qd3QiLCJzdWIiOiJBQkFIQUpPSDc4ODAwNzY0NUFETUlOIiwiaWF0IjoxNTYwNTExMjY5LCJleHAiOjE1NjA1MTQ4Njl9.
    jqNBT9TTG18iP9V4SbMBQOBi2b6K9ejTt87nNaCRFQs';
    protected $nonsenseToken = 'eyJ0eXAipPs';

    protected $fakeToken = ['token' => 'eyJpc3MiOiJsdW1lbi1qd3QiLCJzdWIiOiJBQkFIQUpPSDc4ODAwNzY0NUFETUlOIiwiaWF0IjoxNTYwNTExMjY5LCJleHAiOjE1NjA1MTQ4Njl9.
    jqNBT9TTG18iP9V4SbMBQOBi2b6K9ejTt87nNaCRFQs'];
    protected $emptyToken = ['token' => ''];

    protected $newOffTaker = [
        'password' => 'masterAgent12345',
        'account_type' => 'Custom',
        'value_chain' => 'Crop',
        'firstname' => 'masteragent',
        'lastname' => 'masteragent',
        'contact_person' => 'Samuel',
        'phonenumber' => '23456789765',
        'district' => 'Kitgum',
        'address' => 'somewhere',
    ];
    protected $accountRequest = [
        'phonenumber' => '32489765478',
        'firstname' => 'fghjklkjhgf',
        'lastname' => 'fgyuhijokjhgf',
        'organization' => 'somewhere',
    ];
    protected $newMasterAgent = [
        'password' => 'masterAgent12345',
        'account_type' => 'Custom',
        'value_chain' => 'Crop',
        'firstname' => 'masteragent',
        'lastname' => 'masteragent',
        'contact_person' => 'Samuel',
        'phonenumber' => '234567897654',
        'district' => 'Kitgum',
        'address' => 'somewhere',
    ];
    protected $existingMasterAgent = [
        'password' => 'masterAgent12345',
        'account_type' => 'Custom',
        'value_chain' => 'Crop',
        'firstname' => 'masteragent',
        'lastname' => 'masteragent',
        'contact_person' => 'Samuel',
        'phonenumber' => '234567897654',
        'district' => 'Kitgum',
        'address' => 'somewhere',
    ];
    protected $invalidData = [
        'email' => 'admin2020@gmail.com',
        'password' => 'masterAgent12345',
        'account_type' => 'someaccount',
        'value_chain' => 'somevalue',
        'firstname' => 'masteragent',
        'lastname' => 'masteragent',
        'contact_person' => 'Samuel',
        'phonenumber' => '234567897654',
        'district' => 'somewhere',
        'address' => 'somewhere',
    ];

    protected $newDevtPartner = [
        'password' => 'masterAgent12345',
        'account_type' => 'Custom',
        'value_chain' => 'Crop',
        'firstname' => 'masteragent',
        'lastname' => 'masteragent',
        'contact_person' => 'Samuel',
        'phonenumber' => '234567897654',
        'district' => 'Kitgum',
        'address' => 'somewhere',
    ];

    public $shortid;
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->shortid = ShortId::create();
    }
    public function getAdminData()
    {
        return $this->adminData;
    }
    public function getWrongEmail()
    {
        return $this->wrongEmail;
    }
    public function getWrongPassword()
    {
        return $this->wrongPassword;
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
    public function getNewOffTaker()
    {
        $this->newOffTaker['email'] = $this->shortid->generate() . '@gmail.com';
        return $this->newOffTaker;
    }
    public function getNewMasterAgent()
    {
        $this->newMasterAgent['email'] = $this->shortid->generate() . '@gmail.com';
        return $this->newMasterAgent;
    }

    public function getExistingMasterAgent()
    {
        $this->existingMasterAgent['email'] = 'admin1234';
        return $this->existingMasterAgent;
    }

    public function getInvalidToken()
    {
        return $this->invalidToken;
    }
    public function getNonsenseToken()
    {
        return $this->nonsenseToken;
    }
    public function getFakeToken()
    {
        return $this->fakeToken;
    }
    public function getEmptyToken()
    {
        return $this->emptyToken;
    }
    public function getNewDevtPartner()
    {
        $this->newDevtPartner['email'] = $this->shortid->generate() . '@gmail.com';
        return $this->newDevtPartner;
    }
    public function getAccountRequest()
    {
        $this->accountRequest['email'] = $this->shortid->generate() . '@gmail.com';
        return $this->accountRequest;
    }

    public function getInvalidData()
    {
        return $this->invalidData;
    }
}
