<?php

return [
    'name' => 'Ygg',
    'admin_base_url' => 'admin',
    'extensions' => [
        'assets' => [
            'strategy' => 'raw',
        ],
    ],
    'dashboards' => [],
    'resources' => [
        'user' => [
            'list' => \App\Ygg\Users\UserList::class,
            'form' => \App\Ygg\Users\UserForm::class,
            'validator' => \App\Ygg\Users\UserValidator::class,
        ]
    ],
    'menu' => [
        [
            'label' => 'Usuários',
            'icon' => 'fa-user-secret',
            'resource' => 'user'
        ]
    ],
    'global_filters' => [],
    'auth' => [
        'display_attribute' => 'name'
    ]
];
