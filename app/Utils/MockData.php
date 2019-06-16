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

    protected $newOffTaker = [
        'password' => 'offtaker123456',
        'ot_name' => 'offtaker',
        'ot_account_type' => 'Custom',
        'ot_contact_person' => 'Samuel',
        'ot_phonenumber' => '324897654e78',
        'ot_district' => 'fghjklkjhgf',
        'ot_address' => 'fgyuhijokjhgf',
        'ot_valuechain' => 'Dairy',
    ];

    protected $newMasterAgent = [
        'password' => 'masterAgent12345',
        'ma_account_type' => 'Custom',
        'ma_valuechain' => 'Crop',
        'ma_name' => 'masteragent',
        'ma_manager_name' => 'Samuel',
        'ma_phonenumber' => '234567897654',
        'ma_district' => 'somewhere',
        'ma_address' => 'somewhere',
    ];

    protected $wrongMasterAgentAccount = [
        'password' => 'masterAgent12345',
        'ma_account_type' => 'Customs',
        'ma_valuechain' => 'Crop',
        'ma_name' => 'masteragent',
        'ma_manager_name' => 'Samuel',
        'ma_phonenumber' => '234567897654',
        'ma_district' => 'somewhere',
        'ma_address' => 'somewhere',
    ];

    protected $wrongMasterAgentValuchain = [
        'password' => 'masterAgent12345',
        'ma_account_type' => 'Custom',
        'ma_valuechain' => 'Crops',
        'ma_name' => 'masteragent',
        'ma_manager_name' => 'Samuel',
        'ma_phonenumber' => '234567897654',
        'ma_district' => 'somewhere',
        'ma_address' => 'somewhere',
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
}
