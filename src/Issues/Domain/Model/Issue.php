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

use App\Issues\Domain\Exception\IssueAlreadyResolvedException;
use App\Issues\Domain\Exception\IssueNotResolvedYetException;
use App\Projects\Domain\Model\ProjectId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Issue
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36)
     * @var string
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=36)
     * @var string
     */
    private string $projectId;

    /**
     * @ORM\Embedded(class="App\Issues\Domain\Model\Request")
     * @var Request
     */
    private Request $request;

    /**
     * @ORM\Embedded(class="App\Issues\Domain\Model\Exception")
     * @var Exception
     */
    private Exception $exception;

    /**
     * @ORM\OneToMany(targetEntity="App\Issues\Domain\Model\Tag", mappedBy="issue", cascade={"PERSIST"})
     * @var Collection
     */
    private Collection $tags;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @var DateTimeImmutable
     */
    private ?DateTimeImmutable $resolvedAt;

    private function __construct(IssueId $id, ProjectId $projectId, Request $request, Exception $exception)
    {
        $this->id = $id->value();
        $this->projectId = $projectId->value();
        $this->request = $request;
        $this->exception = $exception;
        $this->tags = new ArrayCollection();
    }

    public static function create(IssueId $id, ProjectId $projectId, Request $request, Exception $exception, array $tags = []): self
    {
        $newIssue = new self($id, $projectId, $request, $exception);
        $newIssue->addTagsFromArray($tags);

        return $newIssue;
    }

    public function addTagsFromArray(array $tags): void
    {
        if (empty($tags)) {
            return;
        }

        foreach ($tags as $tagName => $tagValue) {
            $this->addTag(Tag::create($this, TagName::fromString($tagName), TagValue::fromString($tagValue)));
        }
    }

    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
    }

    public function resolve(): void
    {
        if ($this->isResolved()) {
            throw new IssueAlreadyResolvedException();
        }

        $this->resolvedAt = new DateTimeImmutable();
    }

    public function isResolved(): bool
    {
        return !empty($this->resolvedAt);
    }

    public function unresolve(): void
    {
        if (!$this->isResolved()) {
            throw new IssueNotResolvedYetException();
        }

        $this->resolvedAt = null;
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
        return $this->tags->toArray();
    }
}
