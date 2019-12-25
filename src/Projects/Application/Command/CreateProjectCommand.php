<?php

declare(strict_types=1);

namespace App\Projects\Application\Command;

use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Model\ProjectName;
use App\Projects\Domain\Model\ProjectUrl;
use App\Shared\Application\Command\CommandInterface;

class CreateProjectCommand implements CommandInterface
{
    /**
     * @var ProjectId
     */
    private ProjectId $id;
    /**
     * @var ProjectName
     */
    private ProjectName $name;
    /**
     * @var ProjectUrl
     */
    private ProjectUrl $url;

    public function __construct(string $id, string $name, string $url)
    {
        $this->id = ProjectId::fromString($id);
        $this->name = ProjectName::fromString($name);
        $this->url = ProjectUrl::fromString($url);
    }

    /**
     * @return ProjectId
     */
    public function getId(): ProjectId
    {
        return $this->id;
    }

    /**
     * @return ProjectName
     */
    public function getName(): ProjectName
    {
        return $this->name;
    }

    /**
     * @return ProjectUrl
     */
    public function getUrl(): ProjectUrl
    {
        return $this->url;
    }
}
