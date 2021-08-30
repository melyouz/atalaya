<?php
/*
 *
 * @copyright 2019-present Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/melyouz
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

/**
 * @ORM\Entity()
 * @ORM\Table("app_project")
 */
class Project
{
    public const VIEW = 'view';
    public const LIST_ISSUES = 'list_issues';
    public const EDIT = 'edit';
    public const ARCHIVE = 'archive';
    public const UNARCHIVE = 'unarchive';

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36)
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private string $url;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private string $token;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private string $platform;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     *
     * @var DateTimeImmutable
     */
    private ?DateTimeImmutable $archivedAt = null;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private string $userId;

    public function __construct(ProjectId $id, ProjectName $name, ProjectUrl $url, ProjectToken $token, ProjectPlatform $platform, UserId $userId)
    {
        $this->id = $id->value();
        $this->name = $name->value();
        $this->url = $url->value();
        $this->token = $token->value();
        $this->platform = $platform->value();
        $this->userId = $userId->value();
        $this->createdAt = new DateTimeImmutable();
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
