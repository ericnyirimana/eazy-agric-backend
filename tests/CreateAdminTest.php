<?php

use App\Utils\MockData;

class CreateAdmin extends TestCase
{
    protected $response, $token, $wrongUser, $mock;
    const URL = '/api/v1/admin';

    public function setUp(): void
    {
        parent::setUp();
        $this->mock = new MockData();
        $this->response = $this->call('POST',
            '/api/v1/auth/login', $this->mock->getLoginDetails());

        $data = json_decode($this->response->getContent(), true);
        $this->token = $data['token'];

        $data2 = $this->call('POST', '/api/v1/auth/login', $this->mock->getMasterAgentData());

        $decoded_data = json_decode($data2->getContent(), true);
        $this->wrongUser = $decoded_data['token'];
    }

    public function testShouldReturnErrorIfNoToken()
    {
        $this->post(self::URL, $this->mock->getAdminData());
        $this->seeStatusCode(401);
        $this->seeJson(['error' => 'Please log in first.']);
    }

    public function testShouldReturnErrorIfInvalidToken()
    {
        $this->post(self::URL,
            ['Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.
            eyJpc3MiOiJsdW1lbi1qd3QiLCJzdWIiOiJBQkFIQUpPSDc4ODAwNzY0NUFETUlOIiwiaWF0IjoxNTYwNTExMjY5LCJleHAiOjE1NjA1MTQ4Njl9.
            jqNBT9TTG18iP9V4SbMBQOBi2b6K9ejTt87nNaCRFQs', ]);
        $this->seeStatusCode(401);
    }

    public function testShouldReturnUserIfTokenIsValid()
    {
        $this->post(self::URL, $this->mock->getNewAdmin(),
            ['Authorization' => $this->token]);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
    }
    public function testShouldReturnErrorIfPasswordMismatch()
    {
        $this->post(self::URL, $this->mock->getPasswordMismatchData(),
            ['Authorization' => $this->token]);
        $this->seeJson(['error' => 'Passwords does not match.']);
    }

    public function testShouldReturnErrorIfUserIsNotAdmin()
    {
        $this->post(self::URL, $this->mock->getNewAdmin(),
            ['Authorization' => $this->wrongUser]);
        $this->seeStatusCode(403);
    }
}
