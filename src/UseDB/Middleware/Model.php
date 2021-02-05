<?php

namespace UseDB\Middleware;

use Closure;
use Illuminate\Http\Request;

class Model
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $collection = $request->collection;
        $payload = $request->payload;
        $errors = [];

        $modelClass = "App\Models\\" . $collection;
        if (!class_exists($modelClass)) {
            return ["Error" => "Model Class '" . $collection . "' doesn't exists in the project"];
        }

        $model = new $modelClass();

        $properties = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
        if (array_key_exists('where', $payload)) {

            $where = $payload['where'];
            foreach ($where as $prop => $value) {
                if (!in_array($prop, $properties)) {
                    $errors['where'][$prop] = 'Property \'' . $prop . '\' provided in the where field doesn\'t exists in ' . $collection;
                }
            }
        }

        if (array_key_exists('data', $payload)) {
            $data = $payload['data'];

            foreach ($data as $prop => $value) {
                if (!in_array($prop, $properties)) {
                    $errors['data'][$prop] = 'Property \'' . $prop . '\' provided in the data field doesn\'t exists in ' . $collection;
                }
            }
        }

        if (!empty($errors)) {
            return response()->json(['errors' => $errors]);
        }
        return $next($request);
    }
}
