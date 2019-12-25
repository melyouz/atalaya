<?php

declare(strict_types=1);

namespace App\Issues\Domain\Repository;

use App\Issues\Domain\Exception\TagNotFoundException;
use App\Issues\Domain\Model\IssueId;
use App\Issues\Domain\Model\Tag;
use App\Issues\Domain\Model\TagName;

interface TagRepositoryInterface
{
    /**
     * @param IssueId $issueId
     * @param TagName $name
     * @return Tag
     * @throws TagNotFoundException
     */
    public function get(IssueId $issueId, TagName $name): Tag;

    /**
     * @param IssueId $issueId
     * @return array
     */
    public function findAllByIssueId(IssueId $issueId): array;

    /**
     * @param Tag $tag
     */
    public function save(Tag $tag): void;
}
