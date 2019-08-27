<?php
use App\Utils\MockData;

class AccountRequestTest extends TestCase
{
    protected $mock, $response;

    public function setUp(): void
    {
        parent::setUp();
        $this->mock = new MockData();

    }

    public function testShouldReturnOfftakersRequestDetails()
    {
       $response = $this->post('api/v1/request/offtaker', $this->mock->getAccountRequest());
       $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
    }

    public function testShouldReturnMasteragentRequestDetails()
    {
        $response = $this->post('api/v1/request/masteragent', $this->mock->getAccountRequest());
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
    }
}
