<?php

declare(strict_types=1);

namespace Kkroff\Todolist\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

class Task extends AbstractEntity
{
    #[Extbase\Validate(['validator' => 'StringLength', 'options' => ['maximum' => 255]])]
    #[Extbase\Validate(['validator' => 'NotEmpty'])]
    protected string $title = '';

    #[Extbase\Validate(['validator' => 'StringLength', 'options' => ['maximum' => 255]])]
    protected string $description = '';

    protected bool $isDone = false;

    protected ?\DateTime $dueDate = null;

    // Title
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    // Description
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    // IsDone
    public function isIsDone(): bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): void
    {
        $this->isDone = $isDone;
    }

    // DueDate
    public function getDueDate(): ?\DateTime
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTime $dueDate): void
    {
        $this->dueDate = $dueDate;
    }
}