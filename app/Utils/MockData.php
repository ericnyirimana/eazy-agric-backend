<?php
namespace App\Utils;

use Crisu83\ShortId\ShortId;

class MockData
{
    protected $adminData = ['email' => 'someone@gmail.com', 'password' => '123456'];
    protected $wrongEmail = ['email' => 'someone@gmail.com', 'password' => '1234567'];
    protected $wrongPassword = ['email' => 'admin1234@gmail.com', 'password' => '1234567'];
    protected $wrongChangePassword = [ 'oldPassword' => '234retgfd23', 'newPassword' => 'admin2020'];
    protected $correctPasswordChange = [ 'oldPassword' => 'admin2020', 'newPassword' => 'admin2020'];
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
    jqNBT9TTG18iP9V4SbMBQOBi2b6K9ejTt87nNaCRFQs', ];
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
        'address' => 'somewhere',
    ];
    protected $newMasterAgent = [
        'account_type' => 'Custom',
        'password' => 'masterAgent12345',
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

    protected $validVaData = [[
      'agriculture_experience_in_years' => 'NA',
      'assets_held' => 'NA',
      'certification_doc_url' => 'NA',
      'education_doc_url' => 'NA',
      'education_level' => 'NA',
      'eloquent_type' => 'va',
      'farmers_enterprises' => 'NA',
      'ma_id' => 'NA',
      'other_occupation' => 'NA',
      'partner_id' => 'NA',
      'password' => '$2y$10$0hRHy0Ktg8QW3cAfDqgdvuP4YfwjYMBzunlY5LcrxrdsORahMAu7u',
      'position held_in_community' => 'NA',
      'service_provision_experience_in_years' => 'NA',
      'services_va_provides' => 'NA',
      'status' => 'active',
      'time' => '2018-07-05T21:48:13:141586',
      'total_farmers_acreage' => 'NA',
      'total_number_of_farmers' => 'NA',
      'type' => 'va',
      'va_country' => 'Uganda',
      'va_district' => 'Bushenyi',
      'va_dob' => 'NA',
      'va_gender' => 'female',
      'va_home_gps_Accuracy' => 'NA',
      'va_home_gps_Altitude' => 'NA',
      'va_home_gps_Latitude' => 'NA',
      'va_home_gps_Longitude' => 'NA',
      'va_id_number' => 'NA',
      'va_id_type' => 'NA',
      'va_name' => 'Prof. Colton Stoltenberg Jr.',
      'va_parish' => 'Nyakariro',
      'va_phonenumber' => '',
      'va_photo' => 'https =>\/\/drive.google.com\/open?id=1MwZuPcWTOcJYa6536Buk9FEc5i7HrZ3U',
      'va_region' => 'Western',
      'va_subcounty' => 'Bwambara',
      'va_village' => 'Kashayo'
    ]];
  
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
        $this->newAdmin['_id'] = $this->shortid->generate();
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

    public function getWrongChangePassword()
    {
        return $this->wrongChangePassword;
    }
    public function getChangePassword()
    {
        return $this->correctPasswordChange;
    }
    public function getValidVaData() {
      $this->validVaData[0]['ma_id'] = $this->shortid->generate();
      $this->validVaData[0]['va_phonenumber'] = mt_rand(1000000000, 9999999999);
      return $this->validVaData;
    }
    public function getDuplicateVaPhoneNo() {
      $this->validVaData[0]['ma_id'] = $this->shortid->generate();
      $this->validVaData[0]['va_phonenumber'] = '1111111111';
      return [$this->validVaData[0], $this->validVaData[0]];
    }
    public function getInvalidVaData() {
      return $this->validVaData;
    }
}
