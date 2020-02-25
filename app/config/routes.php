<?php

return [
    '' => [
        'controller' => 'Index',
        'action' => 'Index'
    ],
    'login' => [
        'controller' => 'User',
        'action' => 'Login'
    ],
    'sing-in' => [
        'controller' => 'User',
        'action' => 'SingIn'
    ],
    'logout' => [
        'controller' => 'User',
        'action' => 'Logout'
    ],
    'task\/create' => [
        'controller' => 'Task',
        'action' => 'Create'
    ],
    'task\/store' => [
        'controller' => 'Task',
        'action' => 'Store'
    ],
    'task\/edit\/(?<id>[0-9]+)' => [
        'controller' => 'Task',
        'action' => 'Edit'
    ],
    'task\/update\/(?<id>[0-9]+)' => [
        'controller' => 'Task',
        'action' => 'Update'
    ]
];
