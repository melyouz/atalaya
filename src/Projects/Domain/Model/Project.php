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

namespace App\Projects\Domain\Model;

use App\Projects\Domain\Exception\ProjectAlreadyArchivedException;
use App\Projects\Domain\Exception\ProjectNotArchivedYetException;
use App\Projects\Domain\Model\Project\ProjectId;
use App\Projects\Domain\Model\Project\ProjectName;
use App\Projects\Domain\Model\Project\ProjectPlatform;
use App\Projects\Domain\Model\Project\ProjectToken;
use App\Projects\Domain\Model\Project\ProjectUrl;
use App\Users\Domain\Model\User\UserId;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity()
 * @ORM\Table("app_project")
 */
class Project
{
    const VIEW = 'view';
    const LIST_ISSUES = 'list_issues';
    const EDIT = 'edit';
    const ARCHIVE = 'archive';
    const UNARCHIVE = 'unarchive';

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36)
     * @var string
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @var string
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=80)
     * @var string
     */
    private string $url;

    /**
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    private string $token;

    /**
     * @ORM\Column(type="string", length=30)
     * @var string
     */
    private string $platform;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @var DateTimeImmutable
     */
    private ?DateTimeImmutable $archivedAt = null;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=false)
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="string", length=36)
     * @var string
     */
    private string $userId;

    /**
     * Project constructor.
     * @param ProjectId $id
     * @param ProjectName $name
     * @param ProjectUrl $url
     * @param ProjectToken $token
     * @param ProjectPlatform $platform
     * @param UserId $userId
     * @throws Exception
     */
    private function __construct(ProjectId $id, ProjectName $name, ProjectUrl $url, ProjectToken $token, ProjectPlatform $platform, UserId $userId)
    {
        $this->id = $id->value();
        $this->name = $name->value();
        $this->url = $url->value();
        $this->token = $token->value();
        $this->platform = $platform->value();
        $this->userId = $userId->value();
        $this->createdAt = new DateTimeImmutable();
    }

    public static function create(ProjectId $id, ProjectName $name, ProjectUrl $url, ProjectToken $token, ProjectPlatform $platform, UserId $userId): self
    {
        return new self($id, $name, $url, $token, $platform, $userId);
    }

    public function archive(): void
    {
        if ($this->isArchived()) {
            throw new ProjectAlreadyArchivedException();
        }

        $this->archivedAt = new DateTimeImmutable();
    }

    public function isArchived(): bool
    {
        return !empty($this->archivedAt);
    }

    public function unarchive(): void
    {
        if (!$this->isArchived()) {
            throw new ProjectNotArchivedYetException();
        }

        $this->archivedAt = null;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function changeName(ProjectName $newName): void
    {
        $this->name = $newName->value();
    }

    public function changeUrl(ProjectUrl $newUrl): void
    {
        $this->url = $newUrl->value();
    }

    public function changePlatform(ProjectPlatform $newPlatform): void
    {
        $this->platform = $newPlatform->value();
    }

    public function getId(): ProjectId
    {
        return ProjectId::fromString($this->id);
    }

    public function getName(): ProjectName
    {
        return ProjectName::fromString($this->name);
    }

    public function getUrl(): ProjectUrl
    {
        return ProjectUrl::fromString($this->url);
    }

    public function getToken(): ProjectToken
    {
        return ProjectToken::fromString($this->token);
    }

    public function getPlatform(): ProjectPlatform
    {
        return ProjectPlatform::fromString($this->platform);
    }

    public function isOwner(UserId $userId): bool
    {
        return $userId->sameValueAs(UserId::fromString($this->userId));
    }
}
