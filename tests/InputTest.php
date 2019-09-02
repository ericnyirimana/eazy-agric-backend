<?php

use App\Utils\InputData;
use App\Models\InputSupplier as InputModel;

class InputTest extends TestCase
{
    protected $token;
    protected $response;
    protected $data;
    protected $mock;
    protected $createInput;
    protected $modelPath = 'App\Models\InputSupplier';
    protected $URL = '/api/v1/inputs/';
    public function setUp(): void
    {
        parent::setUp();
        $this->mock = new InputData();
        $this->response = $this->call(
            'POST',
            '/api/v1/auth/login',
            $this->mock->getLoginDetails()
        );
        $this->data = json_decode($this->response->getContent(), true);
        $this->token = $this->data['token'];
    }
    // view Details
    public function testShouldGetInputDetails()
    {
        // a given user should view input
        $input = factory($this->modelPath)->create();

        $data = $input->_id;
        $URL = $this->URL . $data . '';
        $this->get($URL, ['Authorization' => $this->token]);
        $data = (array) json_decode($this->response->content());
        $this->seeJson(['success' => true]);
        $this->seeStatusCode(200);
        $this->assertArrayHasKey('result', $data);
    }
    public function testUnauthorizedWhenUserTriedToViewInputDetails()
    {
        // a given User should not view Input when he/she is not authenticated
        $input = InputModel::all()->last();
        $URL = $this->URL . $input->_id;
        $this->get($URL, []);
        $this->seeStatusCode(401);
        $this->seeJson(['error' => 'Please log in first.']);
    }

    public function testShouldReturn404Error()
    {
        // a given user should not view input when it is not exist

        $URL = $this->URL . 'e4f9235e-7656-3c73-96fe-b058ac436cf7';
        $this->get($URL, ['Authorization' => $this->token]);
        $this->seeJson(['success' => false, 'error' => 'Input does not exist.']);
        $this->seeStatusCode(404);
    }

    public function testShouldNotUpdateInputWhenIdNotFound()
    {
        // given user should not update input
        // when input not exist
        $URL = $this->URL . 'e4f9235e-7656-3c73-96fe-b058ac436cf7';
        $this->put($URL, $this->mock->getInputsData(), ['Authorization' => $this->token]);
        $this->seeStatusCode(404);
        $this->seeJson(['success' => false, 'error' => 'Input does not exist.']);
    }
    public function testShouldUpdateInput()
    {
        // given user should update input

        $input = InputModel::all()->last();
        $URL = $this->URL . $input->_id;
        $this->put($URL, $this->mock->getInputsData(), ['Authorization' => $this->token]);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true, 'message' => 'updated successfully.']);
    }
    public function testUnauthorizedWhenUserTriedToUpdateInput()
    {
        // given user should not update Input when he/she is not authenticated
        $input = InputModel::all()->last();
        $URL =$this->URL . $input->_id;
        $this->put($URL, []);
        $this->seeStatusCode(401);
        $this->seeJson(['error' => 'Please log in first.']);
    }

    //
    public function testShouldDeleteInput()
    {
        // given user should delete input
        $input = InputModel::all()->last();
        $URL = $this->URL. $input->_id;
        $this->delete($URL, [], ['Authorization' => $this->token]);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true, 'message' => 'Input has been removed.']);
    }

    public function testShouldReturn404ErrorOnDeleteRequest()
    {
        // given user should not delete input
        // when input does not exist

        $URL = $this->URL.'e4f9235e-7656-3c73-96fe-b058ac436cf7';
        $this->delete($URL, [], ['Authorization' => $this->token]);
        $this->seeStatusCode(404);
        $this->seeJson(['success' => false, 'error' => 'Input does not exist.']);
    }
    public function testShouldThrowExceptionError()
    {
        // given user should not update input
        // when there a validationError
        $input = InputModel::all()->last();
        $data = $this->mock->getInputsData();
        $data['name;'] = 'yes';
        $URL = $this->URL . $input->_id;
        $this->put($URL, $data, ['Authorization' => $this->token]);
        $this->seeJson(['error' => 'Error occurred while updating inputs.']);
        $this->seeStatusCode(503);
    }
}
