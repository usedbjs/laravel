<?php

namespace UseDB\Middleware;

use Closure;
use Illuminate\Http\Request;

class UseDB
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
        $obj = $request->all();
        $errors = [];

        if (!array_key_exists('operation', $obj)) {
            $errors['operation'] = "operation field is required";
        } else if (!in_array($obj['operation'], ['create', 'findOne', 'update', 'delete', 'findMany'])) {
            $errors['operation'] = "Invalid operation field";
        }

        if (!array_key_exists('collection', $obj)) {
            $errors['collection'] = "collection field is required";
        }


        if (!array_key_exists('payload', $obj)) {
            $errors['payload'] = "payload field is required";
        }

        if (!empty($errors)) {
            return response()->json(['errors' => $errors]);
        }
        return $next($request);
    }
}
