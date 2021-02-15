<?php

namespace UseDB\Controllers;

use App\Http\Controllers\Controller;


class UseDBReadController extends Controller
{
    public function nestedData($childClasses, $model)
    {
        $modelMethods = get_class_methods($model);

        foreach ($childClasses as $childClassName => $props) {
            if (!in_array($childClassName, $modelMethods)) {
                abort(response()->json('Field written in includes is not a valid subclass', 403));
            }
            $data = $model->$childClassName();
            $data = $this->payload($props, $data);
            $model->$childClassName = $data;
        }
        return $model;
    }

    public function payload($props, $data)
    {
        $data = $this->where($props, $data);
        $data = $this->include($props, $data);
        $data = $this->select($props, $data);
        return $data;
    }

    public function where($props, $data)
    {
        if (array_key_exists('where', $props)) {
            $where = $props['where'];
            $data = $data->where($where);
        }
        return $data->get();
    }

    public function include($props, $data)
    {
        if (array_key_exists('include', $props)) {

            for ($i = 0; $i < count($data); $i++) {
                $data[$i] =  $this->nestedData($props['include'],  $data[$i]);
            }
        }
        return $data;
    }

    public function select($props, $data)
    {
        if (array_key_exists('select', $props)) {
            $select = ['id'];
            $select = array_merge($select, $props['select']);
            if (array_key_exists('include', $props)) {
                foreach ($props['include'] as $name => $value) {
                    array_push($select, $name);
                }
            }

            $data = $data->map(function ($record) use ($select) {
                return  $record->only($select);
            });
        }
        return $data;
    }
}
