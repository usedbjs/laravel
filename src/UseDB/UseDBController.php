<?php

namespace UseDB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UseDBController extends Controller
{
    public $modelClass;

    public function index(Request $request)
    {
        $obj = $request->all();
        $operation = $obj['operation'];
        $this->modelClass = config('usedb.modelPath') . $obj['collection'];

        switch ($operation) {
            case 'create':
                return $this->store($obj);
            case 'findOne':
                return $this->show($obj);
            case 'update':
                // return $this->update($obj['payload']);
                return $this->update($obj);
            case 'delete':
                return $this->destroy($obj);
            case 'findMany':
                return $this->findMany($obj);
        }
    }

    public function findMany($obj)
    {
        $payload = $obj['payload'];
        $errors = [];
        if (!array_key_exists('skip', $payload)) {
            $errors['skip'] = "Skip field in payload is required";
        }
        if (!array_key_exists('take', $payload)) {
            $errors['take'] = "take field in payload is required";
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors]);
        }

        $modelCollection = new $this->modelClass();

        if (array_key_exists('where', $payload)) {
            $modelCollection = $this->modelClass::where($payload['where']);
        }
        $total = $modelCollection->count();
        $modelCollection = $modelCollection->skip($payload['skip'])->take($payload['take']);

        return response()->json(['data' => $modelCollection->get(), 'pagination' => ['total' => $total]]);
    }

    public function store($obj)
    {
        $payload = $obj['payload'];
        if (!array_key_exists('data', $payload)) {
            return ['error' => 'Data field in payload is required'];
        }

        $data = $payload['data'];
        $model = new $this->modelClass();

        foreach ($data as $prop => $value) {
            $model->$prop = $value;
        }

        if (!$model->save()) {
            return response()->json(['errors' => $model->getErrors()]);
        }
        return response()->json($model);
    }


    public function show($obj)
    {
        $payload = $obj['payload'];
        if (!array_key_exists('where', $payload)) {
            return ['error' => 'where field in payload is required'];
        }

        $where =  $payload['where'];
        $model = $this->modelClass::where($where)->first();

        if (!$model)
            return response()->json(["error" => "Record not found!!"]);
        return response()->json($model);
    }


    public function update($obj)
    {
        $payload = $obj['payload'];

        $errors = [];
        if (!array_key_exists('where', $payload)) {
            $errors['where']  = 'where field in payload is required';
        }
        if (!array_key_exists('data', $payload)) {
            $errors['data'] = 'data field is required';
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors]);
        }

        $where =  $payload['where'];
        $model = $this->modelClass::where($where)->first();
        if (!$model)
            return response()->json(["error" => "Record not found"]);

        $data = $payload['data'];
        foreach ($data as $prop => $value) {
            $model->$prop = $value;
        }

        if (!$model->save()) {
            return response()->json(["errors" => "Not saved"]);
        }
        return response()->json($model);
    }


    public function destroy($obj)
    {
        $payload = $obj['payload'];
        if (!array_key_exists('where', $payload)) {
            return ['error' => 'where field in payload is required'];
        }
        $where =  $payload['where'];

        $model = $this->modelClass::where($where)->first();
        if (!$model)
            return response()->json(["error" => "Record not found"]);

        $model->delete();
        return response()->json(["message" => "Record deleted successfully"]);
    }
}
