<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'ToDoList Site',
    'description' => '',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'fluid_styled_content' => '13.4.0-13.4.99',
            'rte_ckeditor' => '13.4.0-13.4.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Kkroff\\TodolistSite\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Christoph Jerchel',
    'author_email' => 'c.jerchel@gmail.com',
    'author_company' => 'KKroff',
    'version' => '1.0.0',
];
