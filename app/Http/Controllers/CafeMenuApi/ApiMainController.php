<?php

namespace App\Http\Controllers\CafeMenuApi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class ApiMainController extends Controller
{
    protected string $modelClass;
    protected string $resourceClass;

    public function __construct()
    {
        $this->validate_classes();
    }

    private function validate_classes()
    {
        // Check if the model is a valid Eloquent model and resource is a valid JsonResource
        if (!is_subclass_of($this->modelClass, Model::class) || !is_subclass_of($this->resourceClass, JsonResource::class)) {
            throw new \InvalidArgumentException("Invalid model or resource");
        } else {
            return true;
        }
    }

    private function get_model_name()
    {
        $model_string = explode('\\', $this->modelClass);
        return end($model_string);
    }

    protected function validateData(array $data, array $rules)
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors = $this->validation_error($validator->errors()->first());
            return response()->json($errors, $errors['status']);
        }

        return $validator->validated();
    }

    /**
     * Show all resources
     */
    protected function showAll()
    {
        $models = $this->modelClass::all();

        if ($models->isEmpty()) {
            $response = [
                'status' => 404,
                'content' => 'No '. $this->get_model_name() .' found!',
            ];
        } else {
            $response = [
                'status' => 200,
                'content' => $this->resourceClass::collection($models),
            ];
        }

        return $response;
    }

    /**
     * Save a resource
     *
     * @param array $data Data to be saved in the table
     */
    protected function save(array $data)
    {
        try {
            $user = $this->modelClass::query()->create($data);
        } catch (QueryException $qe) {
            $error = $this->sql_error($qe);
            return response()->json($error, $error['status']);
        }

        return [
            'status' => 201,
            'content' => new $this->resourceClass($user),
        ];
    }

    /**
     * Show a single resource
     *
     * @param int $id
     */
    protected function showSingle(int $id)
    {
        $user = $this->modelClass::query()->find($id);

        if (is_null($user)) {
            $response = [
                'status' => 404,
                'content' => $this->get_model_name() . ' not found',
            ];
        } else {
            $response = [
                'status' => 200,
                'content' => new $this->resourceClass($user),
            ];
        }

        return $response;
    }

    /**
     * Update resource
     *
     * @param int $id
     * @param array $data
     */
    protected function edit(int $id, array $data)
    {
        $model = $this->modelClass::find($id);

        if (empty($data)) {
            return [
                'status' => 400,
                'content' => 'At least one of the necessary parameters should be present for the update action.',
            ];
        }

        if (is_null($model)) {
            $response = [
                'status' => 404,
                'content' => $this->get_model_name() . ' not found',
            ];
        } else {
            try {
                $model->update(array_filter($data));
            } catch (QueryException $qe) {
                $error = $this->sql_error($qe);
                return $error;
            }
            $response = [
                'status' => 200,
                'content' => new $this->resourceClass($model),
            ];
        }

        return $response;
    }

    /**
     * Delete a resource
     *
     * @param int $id
     */
    protected function delete(int $id)
    {
        $user = $this->modelClass::query()->find($id);

        if (is_null($user)) {
            $response = [
                'status' => 404,
                'content' => $this->get_model_name() . ' not found',
            ];
        } else {
            $user->delete();
            $response = [
                'status' => 200,
                'content' => $this->get_model_name() . ' deleted successfully!',
            ];
        }

        return $response;
    }

    /**
     * Throws a SQL statement error
     *
     * @param $query_exception
     * @return mixed
     */
    protected function sql_error($query_exception)
    {
        $errorMessage = $query_exception->errorInfo[2];
        if (str_contains($errorMessage, 'Duplicate entry')) {
            // Extract the duplicate entry and the field name if needed
            preg_match("/Duplicate entry '([^']+)' for key '([^']+)'/", $errorMessage, $matches);
            if (isset($matches[1]) && isset($matches[2])) {
                $duplicateValue = $matches[1];
                $key = $matches[2];

                $keyMap = [
                    'users_email_unique' => 'email',
                    'users_phone_number_unique' => 'phone number',
                ];

                return [
                    'status' => 409,
                    'error' => "The value '$duplicateValue' already exists for the '$keyMap[$key]'. Please use a different value.",
                ];
            }

            return [
                'status' => 409,
                'error' => 'Duplicate entry detected!'
            ];
        } else {
            return [
                'status' => 409,
                'error' => $query_exception->errorInfo[2],
            ];
        }
    }

    /**
     * Throw data validation error
     *
     * @param $errors
     */
    protected function validation_error($errors)
    {
        return [
            'status' => 422,
            'errors' => $errors,
        ];
    }
}
