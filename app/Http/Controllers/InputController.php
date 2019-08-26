<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Helpers;
use App\Utils\Validation;


class InputController extends Controller
{
    protected $request, $validate;
    public function __construct(Request $request)
    {
        $this->validate = new Validation();
        $this->request = $request;
    }

    /**
     * View single Input
     */
    public function getInputDetails($id)
    {

        try {
            $input = Helpers::checkInput($id)->first();
            return $input ? Helpers::returnSuccess(200, [
                'result' => $input
            ], "") : Helpers::returnError("Input does not exist.", 404);
        } catch (\Exception $e) {
            return Helpers::returnError("Error occured please try again later.", 503);
        }
    }

    /**
     * Updating Inputs
     */
    public function updateInput(Request $request, $id)
    {
        $this->validate->validateInput($this->request);
        try {
            $input = Helpers::checkInput($id);
            if (!$input->first()) {
                return Helpers::returnError("Input does not exist.", 404);
            }
            $updates = $input->update($request->all());
            return Helpers::returnSuccess(200, [
                'message' => 'updated successfully.',
                'result' => $updates
            ], "");
        } catch (\Exception $e) {
            return Helpers::returnError("Error occurred while updating inputs.", 503);
        }
    }

    /**
     * delete Input
     */
    public function deleteInput($id)
    {
        try {
            $input = Helpers::checkInput($id);
            if (!$input->first()) {
                return Helpers::returnError("Input does not exist.", 404);
            }
            $input->delete();
            return Helpers::returnSuccess(200, [
                'message' => 'Input has been removed.',
            ], "");
        } catch (\Exception $e) {
            return Helpers::returnError("Error occurred while removing input, please try again later.", 503);
        }
    }
}
