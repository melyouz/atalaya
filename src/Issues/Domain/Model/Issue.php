<?php
/**
 *
 * @copyright 2019 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

declare(strict_types=1);

namespace App\Issues\Domain\Model;

use App\Projects\Domain\Model\ProjectId;

class Issue
{
    private string $id;
    private string $projectId;
    private Request $request;
    private Exception $exception;
    /** @var Tag[] */
    private array $tags = [];

    private function __construct(IssueId $id, ProjectId $projectId, Request $request, Exception $exception)
    {
        $this->id = $id->value();
        $this->projectId = $projectId->value();
        $this->request = $request;
        $this->exception = $exception;
    }

    public static function create(IssueId $id, ProjectId $projectId, Request $request, Exception $exception, array $tags = [])
    {
        $newIssue = new self($id, $projectId, $request, $exception);
        $newIssue->addTagsFromArray($tags);

        return $newIssue;
    }

    public function addTagsFromArray(array $tags)
    {
        if (empty($tags)) {
            return;
        }

        foreach($tags as $tagName => $tagValue) {
            if (!$this->tagExists($tagName)) {
                $this->tags[] = Tag::create(IssueId::fromString($this->id), TagName::fromString($tagName), TagValue::fromString($tagValue));
            }
        }
    }

    public function tagExists(string $tagName): bool
    {
        foreach($this->tags as $tag) {
            if ($tag->getName() === $tagName) {
                return true;
            }
        }

        return false;
    }

    public function getId(): IssueId
    {
        return IssueId::fromString($this->id);
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getException(): Exception
    {
        return $this->exception;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
}
