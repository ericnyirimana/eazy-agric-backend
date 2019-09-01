<?php
use App\Utils\MockData;

class OrderTest extends TestCase
{
    const COMPLETED_ORDERS_URL = '/api/v1/orders/completed';
    const RECEIVED_ORDERS_URL = '/api/v1/orders/received';
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

    public function testShouldReturnTotalOrders()
    {
        $this->get( '/api/v1/orders', ['Authorization' => $this->token]);
        $res_array = (array) json_decode($this->response->content());
        $this->seeStatusCode(200);
        $this->assertEquals('application/json', $this->response->headers->get('Content-Type'));
        $this->seeJson(['success' => true]);
    }
    public function testShouldReturnAllNewOrdersBetweenDateRange()
    {
        $this->get('/api/v1/orders?start_date=2019-08-08 & end_date=2019-08-28', ['Authorization' => $this->token]);
        $res_array = (array) json_decode($this->response->content());
        $this->seeStatusCode(200);
        $this->assertEquals('application/json', $this->response->headers->get('Content-Type'));
        $this->seeJson(['success' => true]);
    }

    public function testShouldReturnErrorIfWrongDateInput()
    {
        $this->get('/api/v1/orders?start_date=2019-18-08 & end_date=2019-18-0', ['Authorization' => $this->token]);
        $res_array = (array) json_decode($this->response->content());
        $this->seeStatusCode(503);
        $this->assertEquals('application/json', $this->response->headers->get('Content-Type'));
        $this->seeJson(['success' => false]);
        $this->seeJson(['error' => 'Could not get orders']);
    }

    public function testShouldReturnReceivedOrders()
    {
        $this->get(self::RECEIVED_ORDERS_URL, ['Authorization' => $this->token]);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
        $this->seeJsonStructure([
            'received_orders'=> [],
            'count',
            'success'
        ]);
    }

    public function testInvalidRouteParameterReturnsError()
    {
        $this->get('/api/v1/orders/wrong', ['Authorization' => $this->token]);
        $this->seeStatusCode(400);
        $this->seeJson(['success' => false]);
        $this->seeJsonStructure([
            'success',
            'error'
        ]);
    }
}
