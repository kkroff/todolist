<?php

declare(strict_types=1);

namespace Kkroff\Todolist\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class TaskController extends ActionController
{
    public function showVueElementAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }
}