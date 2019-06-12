<?php

class Login extends TestCase
{

    public function testShouldReturnAnErrorIfWrongEmail()
    {
        $this->post('/api/v1/auth/login', ['email' => 'someone@gmail.com', 'password' => '123456']);
        $this->seeStatusCode(404);
        $this->seeJson(['error' => 'The Email or password supplied is incorrect.']);

    }

    public function testShouldReturnAnErrorIfWrongPassword()
    {
        $this->post('/api/v1/auth/login', ['email' => 'masteragent1234@gmail.com', 'password' => '123456']);
        $this->seeJson(['success' => false]);
        $this->seeStatusCode(404);
        $this->seeJson(['error' => 'The Email or password supplied is incorrect.']);

    }

    public function testShouldReturnSuccessOnSuccessfulLogin()
    {
        $user = $this->post('/api/v1/auth/login', ['email' => 'masteragent1234@gmail.com', 'password' => 'masteragent1234']);
        $this->seeJson(['success' => true]);
        $this->seeStatusCode(200);
        $this->assertIsObject($user);

    }
}
