<?php
class VillageAgentTest extends TestCase
{
    public $response;
    public $token;
    public $wrong_user;
    const URL = '/api/v1/create-admin';

    public function setUp(): void
    {
        parent::setUp();
        $this->response = $this->call('POST',
            '/api/v1/auth/login',
            ['email' => 'admin1234@gmail.com', 'password' => 'admin1234']);

        $data = json_decode($this->response->getContent(), true);
        $this->token = $data['token'];

    }

    public function testShouldReturnVillageAgents()
    {
        $this->get('/api/v1/village-agents', ['Authorization' => $this->token]);
        $this->seeStatusCode(200);
        $this->assertEquals('application/json', $this->response->headers->get('Content-Type'));
        $this->seeJson(['success' => true]);
    }
}
