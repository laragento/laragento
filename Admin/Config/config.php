<?php

return [
    'name' => 'admin',

    'afterlogin_redirect' => '/admin',
    'afterregister_redirect' => '/admin',
    'afterpasswordreset_redirect' => '/admin',

    'modules' => [
        'laragentocms' => 1
    ]
];
