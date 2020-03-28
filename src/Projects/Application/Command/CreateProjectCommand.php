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

namespace App\Projects\Application\Command;

use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Model\ProjectName;
use App\Projects\Domain\Model\ProjectPlatform;
use App\Projects\Domain\Model\ProjectUrl;
use App\Shared\Application\Command\CommandInterface;
use App\Users\Domain\Model\UserId;

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
    /**
     * @var ProjectPlatform
     */
    private ProjectPlatform $platform;

    /**
     * @var UserId
     */
    private UserId $userId;

    public function __construct(string $id, string $name, string $url, string $platform, string $userId)
    {
        $this->id = ProjectId::fromString($id);
        $this->name = ProjectName::fromString($name);
        $this->url = ProjectUrl::fromString($url);
        $this->platform = ProjectPlatform::fromString($platform);
        $this->userId = UserId::fromString($userId);
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

    /**
     * @return ProjectPlatform
     */
    public function getPlatform(): ProjectPlatform
    {
        return $this->platform;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
