<?php

defined('TYPO3') or die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Todolist',
    'Tasks',
    [
        \Kkroff\Todolist\Controller\TaskController::class => 'showVueElement',
    ],
    [
        \Kkroff\Todolist\Controller\TaskController::class => 'showVueElement',
    ]
);


// Load plugin TypoScript automatically after installing
$GLOBALS['TYPO3_CONF_VARS']['FE']['defaultTypoScript']['setup']['todolist'] =
    '@import "EXT:todolist/Configuration/TypoScript/setup.typoscript"';
