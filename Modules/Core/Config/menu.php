<?php

return [
    'users' => [
        'route'      => 'core.user.index',
        'permission' => [84],
        'class'      => '',
        'icon'       => 'fa fa-user',
        'name'       => 'users',
        'text'       => 'core::menu.users',
        'order'      => 7,
        'sub'        => [
            [
                'route'      => 'core.user.index',
                'permission' => [84],
                'class'      => '',
                'icon'       => 'fa fa-user',
                'name'       => 'users',
                'text'       => 'core::menu.users',
                'order'      => 1,
                'sub'        => []
            ],
            [
                'route'      => 'core.role.index',
                'permission' => [88],
                'class'      => '',
                'icon'       => 'fa fa-user',
                'name'       => 'roles',
                'text'       => 'core::menu.roles',
                'order'      => 2,
                'sub'        => []
            ],
            [
                'route'      => 'core.group.index',
                'permission' => [92],
                'class'      => '',
                'icon'       => 'fa fa-user',
                'name'       => 'groups',
                'text'       => 'core::menu.groups',
                'order'      => 3,
                'sub'        => []
            ]
        ]
    ],
    'dashboard' => [
        'route'      => 'core.dashboard',
        'permission' => [],
        'class'      => '',
        'icon'       => 'fa fa-dashboard',
        'name'       => 'dashboard',
        'text'       => 'core::menu.dashboard',
        'order'      => 1,
        'sub'        => []
    ],
    'settings' => [
        'route'      => 'core.settings.index',
        'permission' => [103],
        'class'      => '',
        'icon'       => 'fa fa-cogs',
        'name'       => 'settings',
        'text'       => 'core::menu.settings',
        'order'      => 9,
        'sub'        => [
            [
                'route'      => 'core.settings.index',
                'permission' => [103],
                'class'      => '',
                'icon'       => 'fa fa-cogs',
                'name'       => 'settings',
                'text'       => 'core::menu.settings',
                'order'      => 1,
                'sub'        => []
            ],
            [
                'route'      => 'core.menu.index',
                'permission' => ['core.menu.index'],
                'class'      => '',
                'icon'       => 'fa fa-bars',
                'name'       => 'menus',
                'text'       => 'core::menu.menus',
                'order'      => 2,
                'sub'        => []
            ],
            [
                'route'      => 'core.menu_type.index',
                'permission' => ['core.menu_type.index'],
                'class'      => '',
                'icon'       => 'fa fa-bars',
                'name'       => 'menu_types',
                'text'       => 'core::menu.menu_type',
                'order'      => 3,
                'sub'        => []
            ]
        ]
    ],
];
