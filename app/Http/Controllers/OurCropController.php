<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OurCrop;
use App\Utils\Validation;
use Exception;
use App\Utils\Helpers;

class OurCropController extends Controller
{
    private $request;
    private $validate;
    private $db;
    private $helpers;
    const IMAGE_PATH = 'crops/';

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validate = new Validation();
        $this->helpers = new Helpers();
        $this->db = getenv('DB_DATABASE');
    }

    /**
     * Gets all enterprises in the database
     * @return \Illuminate\Http\JsonResponse response
     */
    public function getEnterprises()
    {
        try {
            $enterprises = OurCrop::query()->selectRaw('crop AS name')->orderBy('crop', 'asc')->get();
            return Helpers::returnSuccess(200, ['data' => $enterprises], "Enterprises retrieved successfully");
        } catch (Exception $e) {
            return Helpers::returnError("Something went wrong.", 503);
        }
    }

    /**
     * Add new crop into the database
     * @return \Illuminate\Http\JsonResponse response
     */
    public function addCrop()
    {
        try {
            $this->validate->validateOurCropsData($this->request);
            $cropInfo = $this->request->all();
            if ($this->request->hasFile('photo')) {
                // @codeCoverageIgnoreStart
                $uploadedFile = $this->request->file('photo');
                $imgUrl = Helpers::processImageUpload($uploadedFile, self::IMAGE_PATH);
                $cropInfo['photo_url'] = $imgUrl;
                // @codeCoverageIgnoreEnd
            }
            OurCrop::create($cropInfo + ['_id' => Helpers::generateId()]);
            $response = OurCrop::latest()->first();
            return Helpers::returnSuccess(201, ['Crop' => $response], "Crop added successfully");
        } catch (Exception $e) {
            return Helpers::returnError("Could not add crop.", 503);
        }
    }

    /**
     * Get Crops
     * @return \Illuminate\Http\JsonResponse response
     */
    public function getCrops()
    {
        $crops = OurCrop::all();
        return Helpers::returnSuccess(200, ['data' => $crops], "");
    }

    /**
     * Get single crop information
     *
     * @return \Illuminate\Http\JsonResponse response
     */
    public function getCrop()
    {
        $id = $this->request->input('id');
        try {
            $singleCropInfo = OurCrop::query()
              ->select()
              ->where('_id', $id)
              ->get();
            return Helpers::returnSuccess(200, ['data' => $singleCropInfo], '');
        } catch (Exception $e) {
            return Helpers::returnError("Could not get crop.", 503);
        }
    }
}
