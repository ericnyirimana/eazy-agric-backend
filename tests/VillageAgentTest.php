<?php
class VillageAgentTest extends TestCase
{
    public function testShouldReturnVillageAgents()
    {
        $this->get('/api/v1/village-agents');
        $this->seeStatusCode(200);
        $this->assertEquals('application/json', $this->response->headers->get('Content-Type'));
        $this->seeJson(['success' => true]);
    }
}
