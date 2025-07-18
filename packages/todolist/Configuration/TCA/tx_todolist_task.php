<?php

return [
    'ctrl' => [
        'title' => 'Task',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'rootLevel' => -1,
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:todolist/Resources/Public/Icons/todo.svg',
        'default_sortby' => 'ORDER BY due_date ASC, crdate DESC',
    ],
    'types' => [
        '1' => ['showitem' => 'is_done,title,description, due_date'],
    ],
    'columns' => [
        'is_done' => [
            'label' => 'Done',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'title' => [
            'label' => 'Title',
            'config' => [
                'type' => 'input',
                'size' => 30,
            ],
        ],
        'description' => [
            'label' => 'Description',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
                'max' => 255,
            ],
        ],
        'due_date' => [
            'label' => 'Due Date',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'date',
                'default' => null,
            ],
        ],
    ],
];