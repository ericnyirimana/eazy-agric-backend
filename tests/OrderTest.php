<?php
use App\Utils\MockData;

class OrderTest extends TestCase
{
    const COMPLETED_ORDERS_URL = '/api/v1/orders/completed';
    protected $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->mock = new MockData();
        $this->response = $this->call('POST', '/api/v1/auth/login', $this->mock->getLoginDetails());
        $result = json_decode($this->response->getContent());
        $this->token = $result->token;
    }

    public function testShouldReturnCompletedOrders()
    {
        $this->get(self::COMPLETED_ORDERS_URL, ['Authorization' => $this->token]);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
        $this->seeJsonStructure([
            'completed_orders'=> [],
            'count',
            'success'
        ]);
    }

    public function testRouteRequiresAuthentication()
    {
        $this->get(self::COMPLETED_ORDERS_URL);
        $this->seeStatusCode(401);
        $this->assertEquals('application/json', $this->response->headers->get('Content-Type'));
        $this->seeJson(['success' => false]);
        $this->seeJson(['error' => 'Please log in first.']);
    }
}
