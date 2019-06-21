<?php
namespace App\Utils;

use Crisu83\ShortId\ShortId;

class MockData
{
    protected $adminData = ['email' => 'someone@gmail.com', 'password' => '123456'];
    protected $wrongEmail = ['email' => 'someone@gmail.com', 'password' => '1234567'];
    protected $wrongPassword = ['email' => 'admin1234@gmail.com', 'password' => '1234567'];
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
    protected $invalidToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.
    eyJpc3MiOiJsdW1lbi1qd3QiLCJzdWIiOiJBQkFIQUpPSDc4ODAwNzY0NUFETUlOIiwiaWF0IjoxNTYwNTExMjY5LCJleHAiOjE1NjA1MTQ4Njl9.
    jqNBT9TTG18iP9V4SbMBQOBi2b6K9ejTt87nNaCRFQs';
    protected $nonsenseToken = 'eyJ0eXAipPs';

    protected $newOffTaker = [
        'password' => 'offtaker123456',
        'ot_name' => 'offtaker',
        'account_type' => 'Custom',
        'ot_contact_person' => 'Samuel',
        'phonenumber' => '324897654e78',
        'ot_district' => 'fghjklkjhgf',
        'ot_address' => 'fgyuhijokjhgf',
        'value_chain' => 'Dairy',
    ];

    protected $accountRequest = [
        'phonenumber' => '324897654e78',
        'firstname' => 'fghjklkjhgf',
        'lastname' => 'fgyuhijokjhgf',
        'organization' => 'somewhere',
    ];

    protected $newMasterAgent = [
        'password' => 'masterAgent12345',
        'account_type' => 'Custom',
        'value_chain' => 'Crop',
        'ma_name' => 'masteragent',
        'ma_manager_name' => 'Samuel',
        'phonenumber' => '234567897654',
        'ma_district' => 'somewhere',
        'ma_address' => 'somewhere',
    ];

    protected $wrongMasterAgentAccount = [
        'password' => 'masterAgent12345',
        'account_type' => 'Customs',
        'value_chain' => 'Crop',
        'ma_name' => 'masteragent',
        'ma_manager_name' => 'Samuel',
        'phonenumber' => '234567897654',
        'ma_district' => 'somewhere',
        'ma_address' => 'somewhere',
    ];

    protected $wrongMasterAgentValuechain = [
        'password' => 'masterAgent12345',
        'account_type' => 'Custom',
        'value_chain' => 'Crops',
        'ma_name' => 'masteragent',
        'ma_manager_name' => 'Samuel',
        'phonenumber' => '234567897654',
        'ma_district' => 'somewhere',
        'ma_address' => 'somewhere',
    ];

    protected $newDevtPartner = [
        'password' => 'masterAgent12345',
        'account_type' => 'Custom',
        'value_chain' => 'Crop',
        'dp_name' => 'masteragent',
        'dp_contact_person' => 'Samuel',
        'phonenumber' => '234567897654',
        'dp_district' => 'somewhere',
        'dp_address' => 'somewhere',
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
        $this->newOffTaker['ot_username'] = $this->shortid->generate();
        return $this->newOffTaker;

    }

    public function getNewMasterAgent()
    {
        $this->newMasterAgent['email'] = $this->shortid->generate() . '@gmail.com';
        $this->newMasterAgent['ma_username'] = $this->shortid->generate();
        return $this->newMasterAgent;
    }

    public function getWrongMasterAgentAccount()
    {
        $this->wrongMasterAgentAccount['email'] = $this->shortid->generate() . '@gmail.com';
        $this->wrongMasterAgentAccount['ma_username'] = $this->shortid->generate();
        return $this->wrongMasterAgentAccount;
    }

    public function getWrongMasterAgentValuchain()
    {
        $this->wrongMasterAgentValuchain['email'] = $this->shortid->generate() . '@gmail.com';
        $this->wrongMasterAgentValuchain['ma_username'] = $this->shortid->generate();
        return $this->wrongMasterAgentValuchain;
    }
    public function getInvalidToken()
    {
        return $this->invalidToken;
    }
    public function getNonsenseToken()
    {
        return $this->nonsenseToken;
    }
    public function getNewDevtPartner()
    {
        $this->newDevtPartner['email'] = $this->shortid->generate() . '@gmail.com';
        $this->newDevtPartner['dp_username'] = $this->shortid->generate();
        return $this->newDevtPartner;
    }
    public function getAccountRequest()
    {
        $this->accountRequest['email'] = $this->shortid->generate() . '@gmail.com';
        return $this->accountRequest;
    }
}
