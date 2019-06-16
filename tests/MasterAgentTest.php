<?php
use App\Utils\MockData;

class CreateMasterAgentTest extends TestCase
{
    protected $response, $token, $wrongUser, $mock;

    const URL = '/api/v1/masteragent';

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
            jqNBT9TTG18iP9V4SbMBQOBi2b6K9ejTt87nNaCRFQs']);
        $this->seeStatusCode(401);

    }
    public function testShouldReturnUserIfTokenIsValid()
    {
        $this->post(self::URL, $this->mock->getNewMasterAgent(),
            ['Authorization' => $this->token]);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
    }
    public function testShouldReturnErrorIfNonsenseToken()
    {
        $this->post(self::URL, $this->mock->getNewMasterAgent(),
            ['Authorization' => 'xfdgghhjk']);
        $this->seeStatusCode(400);
        $this->seeJson(['error' => 'An error occured while decoding token.']);
    }

    public function testShouldReturnErrorIfExpiredToken()
    {
        $this->post(self::URL, $this->mock->getNewMasterAgent(),
            ['Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsdW1lbi1qd3QiLCJzdWIiOiJuMjlCQjB4IiwiaWF0IjoxNTYwNzk3OTYwLCJleHAiOjE1NjA4MDE1NjB9.htsI-0CmYkZom0_KDJokLc3AnaBovVmzRejKxw4Ffcs']);
        $this->seeStatusCode(400);
        $this->seeJson(['error' => 'Your current session has expired, please log in again.']);
    }

    public function testShouldReturnErrorIfUserIsNotAdmin()
    {
        $this->post(self::URL, $this->mock->getNewMasterAgent(),
            ['Authorization' => $this->wrongUser]);
        $this->seeStatusCode(403);
    }

}
