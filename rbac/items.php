<?php

return [
    'author_add_edit_delete' => [
        'type' => 2,
    ],
    'author_view' => [
        'type' => 2,
    ],
    'author_subscribe' => [
        'type' => 2,
    ],
    'book_add_edit_delete' => [
        'type' => 2,
    ],
    'book_view' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'ruleName' => 'UserRole',
        'children' => [
            'author_view',
            'author_subscribe',
            'book_view',
        ],
    ],
    'user' => [
        'type' => 1,
        'ruleName' => 'UserRole',
        'children' => [
            'author_view',
            'author_add_edit_delete',
            'author_subscribe',
            'book_view',
            'book_add_edit_delete',
        ],
    ],
];
