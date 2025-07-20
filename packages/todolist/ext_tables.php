<?php

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;

defined('TYPO3') or die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_todolist_domain_model_task');

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(IconRegistry::class);

$iconRegistry->registerIcon(
    'todolist-plugin-tasks',
    SvgIconProvider::class,
    ['source' => 'EXT:todolist/Resources/Public/Icons/todo.svg']
);