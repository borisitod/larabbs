<?php

use App\Models\Link;

return [
    'title'   => 'Resource recommendation',
    'single'  => 'Resource recommendation',

    'model'   => Link::class,

    // 访问权限判断
    'permission'=> function()
    {
        // 只允许站长管理资源推荐链接
        return Auth::user()->hasRole('Founder');
    },

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title'    => 'Title',
            'sortable' => false,
        ],
        'link' => [
            'title'    => 'URL',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => 'Management',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => [
            'title'    => 'Title',
        ],
        'link' => [
            'title'    => 'URL',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title' => 'Title',
        ],
    ],
];
