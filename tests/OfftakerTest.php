<?php
class OfftakerTest extends TestCase
{
    public function testShouldReturnOfftakers()
    {
        $this->get('/api/v1/offtakers');
        $this->seeStatusCode(200);
        $this->assertEquals('application/json', $this->response->headers->get('Content-Type'));
        $this->seeJson(['success' => true]);
    }
}
