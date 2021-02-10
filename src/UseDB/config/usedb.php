<?php

return [
    'middleware' => [
        'usedb',
        'model-usedb',
    ],
    "modelPath" => "App\Models\\",
    'permissions' => [
        'gates' => [

            // structure

            // 'modelName' => [
            //     'update' => [],
            //     'delete' => [],
            //     'create' => [],
            //     'findOne' => [],
            //     'findMany' => []
            // ]

        ],
        'policies' => [

            // structure

            // 'modelName' => [
            //     'update' => '',
            //     'delete' => '',
            //     'create' => '',
            //     'findOne' => '',
            //     'findMany' => ''
            // ]
        ]
    ]
];
