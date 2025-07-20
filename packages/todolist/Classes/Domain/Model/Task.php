<?php

declare(strict_types=1);

namespace Kkroff\Todolist\Domain\Model;

use SourceBroker\T3api\Annotation\ApiResource;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/task",
 *          },
 *          "post"={
 *              "method"="POST",
 *              "path"="/task",
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/task/{id}",
 *          },
 *          "patch"={
 *               "method"="PATCH",
 *               "path"="/task/{id}",
 *           },
 *           "delete"={
 *               "method"="DELETE",
 *               "path"="/task/{id}",
 *           },
 *     },
 * )
 */
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
