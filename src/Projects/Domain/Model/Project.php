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
use DateTimeImmutable;

class Project
{
    private string $id;
    private string $name;
    private string $url;
    private ?DateTimeImmutable $archivedAt;

    private function __construct(ProjectId $id, ProjectName $name, ProjectUrl $url)
    {
        $this->id = $id->value();
        $this->name = $name->value();
        $this->url = $url->value();
    }

    public static function create(ProjectId $id, ProjectName $name, ProjectUrl $url): self
    {
        return new self($id, $name, $url);
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

    public function isArchived(): bool
    {
        return !empty($this->archivedAt);
    }

    public function archive(): void
    {
        if ($this->isArchived()) {
            throw new ProjectAlreadyArchivedException();
        }

        $this->archivedAt = new DateTimeImmutable();
    }

    public function recover(): void
    {
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
}
