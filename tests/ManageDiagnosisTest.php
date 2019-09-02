<?php

use App\Utils\DiagnosisMockData;
use App\Models\Diagnosis;
use App\Http\Controllers\DiagnosisController;

class ManageDiagnosisTest extends TestCase
{
    const PEST_URL = '/api/v1/diagnosis/pest';
    const DISEASE_URL = '/api/v1/diagnosis/disease';
    const SINGLE_DIAGNOSIS_URL = '/api/v1/diagnosis/';
    protected $token;
    private $mock;

    public function setUp(): void
    {
        parent::setUp();
        $this->mock = new DiagnosisMockData();
        $this->response = $this->call('POST', '/api/v1/auth/login', $this->mock->getLoginDetails());
        $data = json_decode($this->response->getContent(), true);
        $this->token = $data['token'];
    }
    public function testShouldReturnAllPestDiagnosisInformation()
    {
        $this->get(self::PEST_URL, ['Authorization' => $this->token]);
        $res_array = (array)json_decode($this->response->content());
        $this->seeStatusCode(200);
        $this->assertEquals('application/json', $this->response->headers->get('Content-Type'));
        $this->seeJson(['success' => true]);
        $this->assertArrayHasKey('data', $res_array);
    }

    public function testShouldReturnAllDiseaseDiagnosisInformation()
    {
        $this->get(self::DISEASE_URL, ['Authorization' => $this->token]);
        $res_array = (array)json_decode($this->response->content());
        $this->seeStatusCode(200);
        $this->assertEquals('application/json', $this->response->headers->get('Content-Type'));
        $this->seeJson(['success' => true]);
        $this->assertArrayHasKey('data', $res_array);
    }

    public function testShouldReturnSingleDiagnosisInformation()
    {
        $diagnosisInformation = $this->mock->getDiagnosisInformation();
        $diagnosis = Diagnosis::create($diagnosisInformation)->getAttributes();
        $category = lcfirst($diagnosis['category']);
        $this->get(self::SINGLE_DIAGNOSIS_URL . $category . '/' . $diagnosis['_id'], ['Authorization' => $this->token]);
        $res_array = json_decode($this->response->content(), true);
        $this->seeStatusCode(200);
        $this->assertEquals($res_array['data'][0]['_id'], $diagnosis['_id']);
    }

    public function testShouldCorrectlyEditDiagnosisInformation()
    {
        $diagnosisInformation = $this->mock->getDiagnosisInformation();
        $diagnosis = Diagnosis::create($diagnosisInformation)->getAttributes();
        $category = $diagnosis['category'];
        $this->post(
            self::SINGLE_DIAGNOSIS_URL . "$category/" . $diagnosis['_id'],
            $this->mock->getEditDiagnosisData(),
            ['Authorization' => $this->token]
        );
        $res_array = json_decode($this->response->content(), true);
        $this->seeStatusCode(200);
        $this->assertEquals($res_array['data']['name'], $this->mock->getEditDiagnosisData()['name']);
    }

    public function testShouldReturnErrorIfInvalidDiagnosisIsEdited()
    {
        $diagnosis = Diagnosis::create($this->mock->getDiagnosisInformation())->getAttributes();
        $category = lcfirst($diagnosis['category']);
        $this->post(self::SINGLE_DIAGNOSIS_URL . $category . '/' . $diagnosis['_id'], [], ['Authorization' => $this->token]);
        $this->seeStatusCode(422);
        $this->seeJson([ 'success' => false ]);
    }

    public function testShouldDeleteSuccessfullySingleDiagnosisInformation()
    {
        $diagnosisInformation = $this->mock->getDiagnosisInformation();
        $diagnosis = Diagnosis::create($diagnosisInformation)->getAttributes();
        $this->delete(self::SINGLE_DIAGNOSIS_URL . $diagnosis['_id'], [], ['Authorization' => $this->token]);
        $res_array = json_decode($this->response->content(), true);
        $this->seeStatusCode(200);
        $this->assertEquals($res_array['data'], null);
    }

    public function testShouldReturnErrorIfInvalidDiagnosisInformationTriedToBeDeleted()
    {
        $diagnosisInformation = $this->mock->getInvalidDiagnosisData();
        $diagnosis = Diagnosis::create($diagnosisInformation)->getAttributes();
        $this->delete(self::SINGLE_DIAGNOSIS_URL . $diagnosis['_id'], [], ['Authorization' => $this->token]);
        $this->seeStatusCode(503);
        $this->seeJson([ 'success' => false, 'error' => 'Error deleting diagnosis information.' ]);
    }

    public function testShouldReturnErrorIfCategoryIsInvalid()
    {
        $nonExistingCategory = 'ezyagric';
        $this->get(self::SINGLE_DIAGNOSIS_URL . $nonExistingCategory, ['Authorization' => $this->token]);
        $this->seeStatusCode(422);
        $this->seeJson([
            'success' => false,
            'error' => 'Invalid category supplied.'
        ]);
    }

    public function testShouldReturnNotFoundIfDiagnosisDoesNotExist()
    {
        $nonExistingID = 'ezyagric';
        $this->delete(self::SINGLE_DIAGNOSIS_URL . $nonExistingID, [], ['Authorization' => $this->token]);
        $this->seeStatusCode(404);
        $this->seeJson([
            'success' => false,
            'error' => 'Document not found'
        ]);
    }
}
