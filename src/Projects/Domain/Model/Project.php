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
use App\Users\Domain\Model\UserId;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Project
{
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
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @var DateTimeImmutable
     */
    private ?DateTimeImmutable $archivedAt = null;

    /**
     * @ORM\Column(type="string", length=36)
     * @var string
     */
    private string $userId;

    private function __construct(ProjectId $id, ProjectName $name, ProjectUrl $url, UserId $userId)
    {
        $this->id = $id->value();
        $this->name = $name->value();
        $this->url = $url->value();
        $this->userId = $userId->value();
    }

    public static function create(ProjectId $id, ProjectName $name, ProjectUrl $url, UserId $userId): self
    {
        return new self($id, $name, $url, $userId);
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

    public function recover(): void
    {
        if (!$this->isArchived()) {
            throw new ProjectNotArchivedYetException();
        }

        $this->archivedAt = null;
    }

    public function changeName(ProjectName $newName): void
    {
        $this->name = $newName->value();
    }

    public function changeUrl(ProjectUrl $newUrl): void
    {
        $this->url = $newUrl->value();
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
}
