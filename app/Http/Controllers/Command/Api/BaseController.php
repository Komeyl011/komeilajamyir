<?php

namespace App\Http\Controllers\Command\Api;

use App\Http\Controllers\ApiMainController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseController extends ApiMainController
{
    public function __construct()
    {
        $this->modelClass = Model::class;
        $this->resourceClass = JsonResource::class;

        parent::__construct();
    }

    /**
     * Return all resources
     */
    public function index()
    {
        $response = $this->showAll();
        return response()->json($response, $response['status']);
    }

    /**
     * Store a resource
     */
    public function store(Request $request)
    {
        $rules = [
            // Validation Rules
        ];
        // Pass the data and rules to the validation method
        $validated = $this->validateData($request->all(), $rules);
        // Check if there's any errors while validating data
        if (array_key_exists('status', $validated) && $validated['status'] !== 200) {
            return response()->json($validated, $validated['status']);
        }

        // any additional checks and custom code goes here

        // Save the validation data
        $response = $this->save($validated);
        return response()->json($response, $response['status']);
    }

    /**
     * Show a single resource's info
     */
    public function show(int $plan)
    {
        $response = $this->showSingle($plan);

        return response()->json($response, $response['status']);
    }

    /**
     * Update resource
     */
    public function update(Request $request, int $plan)
    {
        $rules = [
            // Validation Rules
        ];
        // Pass the data and rules to the validation method
        $validated = $this->validateData($request->all(), $rules);
        // Check if there's any errors while validating data
        if (array_key_exists('status', $validated) && $validated['status'] !== 200) {
            return response()->json($validated, $validated['status']);
        }

        // any additional checks and custom code goes here

        // Update the resource with the validation data
        $response = $this->edit($plan, $validated);

        return response()->json($response, $response['status']);
    }

    /**
     * Delete the requested resource
     */
    public function destroy(int $plan)
    {
        $response = $this->delete($plan);

        return response()->json($response, $response['status']);
    }
}
