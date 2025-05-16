<?php

namespace App\Http\Controllers\CafeMenuApi;

use App\Http\Resources\CafeMenuApi\PlanResource;
use App\Models\CafeMenuApi\Plan;
use Illuminate\Http\Request;

class PlanController extends ApiMainController
{
    public function __construct()
    {
        $this->modelClass = Plan::class;
        $this->resourceClass = PlanResource::class;

        parent::__construct();
    }

    private function custom_data_check($billing_interval)
    {
        $allowed = array_keys((new $this->modelClass())->interval_translator);

        return in_array($billing_interval, $allowed);
    }

    /**
     * Return all plans
     */
    public function index(Request $request)
    {
        $response = $this->showAll();
        return response()->json($response, $response['status']);
    }

    /**
     * Store a plan
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:50',
            'price' => 'required|integer',
            'billing_interval' => 'required|string',
            'features' => 'nullable|json',
        ];
        $validated = $this->validateData($request->only('name', 'price', 'billing_interval', 'features'), $rules);

        if (array_key_exists('status', $validated) && $validated['status'] !== 200) {
            return response()->json($validated, $validated['status']);
        }

        $validated['billing_interval'] = strtolower($validated['billing_interval']);
        if (!$this->custom_data_check($validated['billing_interval'])) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid billing interval',
            ], 400);
        }

        $response = $this->save($validated);
        return response()->json($response, $response['status']);
    }

    /**
     * Show a single plan's info
     */
    public function show(int $plan)
    {
        $response = $this->showSingle($plan);

        return response()->json($response, $response['status']);
    }

    /**
     * Update plan
     */
    public function update(Request $request, int $plan)
    {
        $rules = [
            'name' => 'string|max:50',
            'price' => 'integer',
            'billing_interval' => 'string',
            'features' => 'json',
        ];
        $validated = $this->validateData($request->only('name', 'price', 'billing_interval', 'features'), $rules);

        if (array_key_exists('status', $validated) && $validated['status'] !== 200) {
            return response()->json($validated, $validated['status']);
        }

        $validated['billing_interval'] = strtolower($validated['billing_interval']);
        if (!$this->custom_data_check($validated['billing_interval'])) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid billing interval',
            ], 400);
        }

        $response = $this->edit($plan, $validated);

        return response()->json($response, $response['status']);
    }

    /**
     * Delete the requested plan
     */
    public function destroy(int $plan)
    {
        $response = $this->delete($plan);

        return response()->json($response, $response['status']);
    }
}
