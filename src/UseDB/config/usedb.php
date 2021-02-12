<?php

return [
    'middleware' => [
        'usedb',
        'model-usedb',
    ],
    "modelPath" => "App\Models\\",
    'permissions' => [
        'gates' => [

            // 'modelName' => [
            //     'update' => [],
            //     'delete' => [],
            //     'create' => [],
            //     'findOne' => [],
            //     'findMany' => []
            // ]

        ],
        'policies' => [

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
