<?php

return [
    'middlewares' => [
        'web' => [
            Framework\Http\MiddleWare\Session::class,
            Framework\Http\MiddleWare\CleanPost::class,
            Framework\Http\MiddleWare\CSRF::class
        ],
        'api' => [
            Framework\Http\MiddleWare\CleanPost::class,
            MiddleWares\CORSMiddleWare::class
        ]
    ]
];
