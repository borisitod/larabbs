<?php

use App\Models\Category;

return [
    'title'   => 'Categories',
    'single'  => 'Categories',
    'model'   => Category::class,

    // 对 CRUD 动作的单独权限控制，其他动作不指定默认为通过
    'action_permissions' => [
        // 删除权限控制
        'delete' => function () {
            // 只有站长才能删除话题分类
            return Auth::user()->hasRole('Founder');
        },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title'    => 'Title',
            'sortable' => false,
        ],
        'description' => [
            'title'    => 'Description',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => 'Management',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name' => [
            'title' => 'Title',
        ],
        'description' => [
            'title' => 'Description',
            'type'  => 'textarea',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'Category ID',
        ],
        'name' => [
            'title' => 'Title',
        ],
        'description' => [
            'title' => 'Description',
        ],
    ],
    'rules'   => [
        'name' => 'required|min:1|unique:categories'
    ],
    'messages' => [
        'name.unique'   => 'The category name is duplicated in the database. Please choose another name.',
        'name.required' => 'Please make sure the name has at least one character.',
    ],
];
