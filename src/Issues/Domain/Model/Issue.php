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
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue\Request", mappedBy="issueId")
     * @var Request
     */
    private Request $request;

    /**
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue\Exception", mappedBy="issueId")
     * @var Exception
     */
    private Exception $exception;

    /**
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue\File", mappedBy="issueId")
     * @var File
     */
    private File $file;

    /**
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue\CodeExcerpt", mappedBy="issueId")
     * @var CodeExcerpt
     */
    private CodeExcerpt $codeExcerpt;

    /**
     * @ORM\OneToMany(targetEntity="App\Issues\Domain\Model\Issue\Tag", mappedBy="issueId", cascade={"persist", "remove"})
     * @var Collection
     */
    private Collection $tags;

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

    private function __construct(IssueId $id, ProjectId $projectId, Request $request, Exception $exception, array $tags = [])
    {
        $this->id = $id->value();
        $this->projectId = $projectId->value();
        $this->request = $request;
        $this->exception = $exception;
        $this->tags = new ArrayCollection();
        $this->seenAt = new DateTimeImmutable();
        $this->addTagsFromArray($tags);
    }

    public static function create(IssueId $id, ProjectId $projectId, Request $request, Exception $exception, array $tags = []): self
    {
        return new self($id, $projectId, $request, $exception, $tags);
    }

    public function addRequest(RequestMethod $method, RequestUrl $url, array $headers = []): void
    {
        $this->request = Request::create($this->getId(), $method, $url, $headers);
    }

    public function addException(ExceptionCode $code, ExceptionClass $class, ExceptionMessage $message): void
    {
        $this->exception = Exception::create($this->getId(), $code, $class, $message);
    }

    public function addFile(FilePath $path, FileLine $line, CodeExcerpt $excerpt): void
    {
        $this->file = File::create($this->getId(), $path, $line, $excerpt);
    }

    public function addCodeExcerpt(CodeExcerptId $codeExcerptId, CodeExcerptLanguage $lang, array $codeLines): void
    {
        $this->codeExcerpt = CodeExcerpt::create($codeExcerptId, $this->getId(), $lang, $codeLines);
    }

    private function addTagsFromArray(array $tags): void
    {
        if (empty($tags)) {
            return;
        }

        foreach ($tags as $tagName => $tagValue) {
            $this->addTag(Tag::create($this->getId(), TagName::fromString($tagName), TagValue::fromString($tagValue)));
        }
    }

    private function addTag(Tag $tag): void
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

    public function getProjectId(): ProjectId
    {
        return ProjectId::fromString($this->projectId);
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
