<?php
use App\Utils\MockData;

class ForgotPasswordTest extends TestCase
{
    const URL = '/api/v1/auth/forgot-password';

    public function setUp(): void
    {
        parent::setUp();
        $this->mock = new MockData();
    }

    public function testShouldReturnAnErrorIfEmailDoesNotExist()
    {
        $this->post(self::URL, $this->mock->getWrongEmail());
        $this->seeStatusCode(404);
        $this->seeJson([
            "message" => "We could not find this email in our database.",
            "error" => true
            ]);
    }

    public function testShouldReturnSuccessIfEmailExist()
    {
        $user = $this->post(self::URL, $this->mock->getLoginDetails());
        $this->seeJson([
            "success" => true,
            "message" => "An email with password reset instructions has been sent to your email address. It would expire in 1 hour."
            ]);
        $this->seeStatusCode(200);
    }
}
