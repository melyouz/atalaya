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
use App\Issues\Domain\Exception\IssueCodeExcerptRequired;
use App\Issues\Domain\Exception\IssueExceptionRequired;
use App\Issues\Domain\Exception\IssueFileRequired;
use App\Issues\Domain\Exception\IssueMustBeDraft;
use App\Issues\Domain\Exception\IssueNotResolvedYetException;
use App\Issues\Domain\Exception\IssueRequestRequired;
use App\Issues\Domain\Exception\TagNotFoundException;
use App\Issues\Domain\Model\Issue\CodeExcerpt;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptId;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptLanguage;
use App\Issues\Domain\Model\Issue\Exception;
use App\Issues\Domain\Model\Issue\Exception\ExceptionClass;
use App\Issues\Domain\Model\Issue\Exception\ExceptionCode;
use App\Issues\Domain\Model\Issue\Exception\ExceptionMessage;
use App\Issues\Domain\Model\Issue\File;
use App\Issues\Domain\Model\Issue\File\FileLine;
use App\Issues\Domain\Model\Issue\File\FilePath;
use App\Issues\Domain\Model\Issue\IssueId;
use App\Issues\Domain\Model\Issue\IssueStatus;
use App\Issues\Domain\Model\Issue\Request;
use App\Issues\Domain\Model\Issue\Request\RequestMethod;
use App\Issues\Domain\Model\Issue\Request\RequestUrl;
use App\Issues\Domain\Model\Issue\Tag;
use App\Issues\Domain\Model\Issue\Tag\TagName;
use App\Issues\Domain\Model\Issue\Tag\TagValue;
use App\Projects\Domain\Model\Project\ProjectId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("app_issue")
 */
class Issue
{
    const VIEW = 'view';
    const RESOLVE = 'resolve';
    const UNRESOLVE = 'unresolve';

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
     * @ORM\Column(type="datetime_immutable", nullable=false)
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $seenAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @var DateTimeImmutable
     */
    private ?DateTimeImmutable $resolvedAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $status;

    /**
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue\Request", mappedBy="issue", cascade={"persist", "remove"})
     * @var Request|null
     */
    private ?Request $request = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue\Exception", mappedBy="issue", cascade={"persist", "remove"})
     * @var Exception|null
     */
    private ?Exception $exception = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue\File", mappedBy="issue", cascade={"persist", "remove"})
     * @var File
     */
    private ?File $file = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue\CodeExcerpt", mappedBy="issue", cascade={"persist", "remove"})
     * @var CodeExcerpt|null
     */
    private ?CodeExcerpt $codeExcerpt=null;

    /**
     * @ORM\OneToMany(targetEntity="App\Issues\Domain\Model\Issue\Tag", mappedBy="issue", cascade={"persist", "remove"})
     * @var Collection
     */
    private Collection $tags;

    public function __construct(IssueId $id, ProjectId $projectId, array $tags = [])
    {
        $this->id = $id->value();
        $this->projectId = $projectId->value();
        $this->seenAt = new DateTimeImmutable();
        $this->status = IssueStatus::DRAFT;
        $this->tags = new ArrayCollection();
        $this->addTagsFromArray($tags);
    }

    private function addTagsFromArray(array $tags): void
    {
        if (empty($tags)) {
            return;
        }

        foreach ($tags as $tagName => $tagValue) {
            $this->addTag(new Tag($this, TagName::fromString($tagName), TagValue::fromString($tagValue)));
        }
    }

    private function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
    }

    public function addRequest(RequestMethod $method, RequestUrl $url, array $headers = []): void
    {
        $this->request = new Request($this, $method, $url, $headers);
    }

    public function addException(ExceptionCode $code, ExceptionClass $class, ExceptionMessage $message): void
    {
        $this->exception = new Exception($this, $code, $class, $message);
    }

    public function addFile(FilePath $path, FileLine $line): void
    {
        $this->file = new File($this, $path, $line);
    }

    public function addCodeExcerpt(CodeExcerptId $codeExcerptId, CodeExcerptLanguage $lang, array $rawCodeLines): void
    {
        $this->codeExcerpt = new CodeExcerpt($codeExcerptId, $this, $lang, $rawCodeLines);
    }

    public function open(): void
    {
        if (!$this->isDraft()) {
            throw new IssueMustBeDraft();
        }

        if (!$this->request) {
            throw new IssueRequestRequired();
        }

        if (!$this->exception) {
            throw new IssueExceptionRequired();
        }

        if (!$this->file) {
            throw new IssueFileRequired();
        }

        if (!$this->codeExcerpt) {
            throw new IssueCodeExcerptRequired();
        }

        $this->status = IssueStatus::OPEN;
    }

    public function isDraft(): bool
    {
        return $this->status === IssueStatus::DRAFT;
    }

    public function resolve(): void
    {
        if ($this->isResolved()) {
            throw new IssueAlreadyResolvedException();
        }

        $this->status = IssueStatus::RESOLVED;
        $this->resolvedAt = new DateTimeImmutable();
    }

    public function isResolved(): bool
    {
        return $this->status === IssueStatus::RESOLVED;
    }

    public function unresolve(): void
    {
        if (!$this->isResolved()) {
            throw new IssueNotResolvedYetException();
        }

        $this->status = IssueStatus::OPEN;
        $this->resolvedAt = null;
    }

    public function getId(): IssueId
    {
        return IssueId::fromString($this->id);
    }

    public function getProjectId(): ProjectId
    {
        return ProjectId::fromString($this->projectId);
    }

    public function getStatus(): IssueStatus
    {
        return IssueStatus::fromString($this->status);
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getException(): Exception
    {
        return $this->exception;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function getCodeExcerpt(): CodeExcerpt
    {
        return $this->codeExcerpt;
    }

    public function getTags(): array
    {
        return $this->tags->toArray();
    }

    /**
     * @param TagName $tagName
     * @return bool
     */
    public function hasTag(TagName $tagName): bool
    {
        $result = array_filter($this->tags->toArray(), function (Tag $tag) use ($tagName) {
            return $tag->getName()->sameValueAs($tagName);
        });

        return count($result) > 0;
    }

    /**
     * @param TagName $tagName
     * @return TagValue|null
     * @throws TagNotFoundException
     */
    public function getTagValue(TagName $tagName): ?TagValue
    {
        foreach ($this->tags as $tag) {
            if ($tag->getName()->sameValueAs($tagName)) {
                return $tag->getValue();
            }
        }

        throw new TagNotFoundException();
    }

    public function getSeenAt(): DateTimeImmutable
    {
        return $this->seenAt;
    }
}
