<?php
use App\Utils\MockData;

class AccountRequestTest extends TestCase
{
    protected $mock;

    public function setUp(): void
    {
        parent::setUp();
        $this->mock = new MockData();

    }

    public function testShouldReturnOfftakersRequestDetails()
    {
        $this->post('api/v1/request/offtaker', $this->mock->getAccountRequest());
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
    }

    public function testShouldReturnMasteragentRequestDetails()
    {
        $this->post('api/v1/request/masteragent', $this->mock->getAccountRequest());
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
    }

}
