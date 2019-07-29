<?php

use App\Utils\MockData;
use App\Utils\Helpers;
use App\Http\Controllers\ActivityLogController;

class ActivityLogTest extends TestCase
{
    protected $response, $token, $wrongUser, $mock, $activityLog, $data;
    const URL = '/api/v1/activity-log';

    public function setUp(): void
    {
        parent::setUp();
        $this->mock = new MockData();
        $this->response = $this->call(
            'POST',
            '/api/v1/auth/login',
            $this->mock->getLoginDetails()
        );

        $this->data = json_decode($this->response->getContent(), true);
        $this->token = $this->data['token'];
    }

    public function testShouldReturnActivityLogs()
    {
        $this->get(self::URL, ['Authorization' => $this->token]);
        $res_array = (array) json_decode($this->response->content());

        $this->seeStatusCode(200);
        $this->assertArrayHasKey('activityLog', $res_array);
    }

    public function testShouldCreateNewActivityLog()
    {
        $email = 'fake-admin-email@fakeemail.com';
        $target_email = 'fake-user@fakemail.com';
        $target_firstname = 'samuel';
        $target_lastname = 'El Ali';
        $activity = 'request a dev. partner account.';

        $activityLog = Helpers::logActivity([
            'email' => $email,
            'target_firstname' => $target_firstname,
            'target_lastname' => $target_lastname,
            'target_email' => $target_email,
        ], $activity);

        $res_array = (array) json_decode($activityLog);
        $this->assertEquals($email, $activityLog->email);
        $this->assertEquals($activity, $activityLog->activity);
        $this->assertArrayHasKey('target_lastname', $res_array);
    }
}
