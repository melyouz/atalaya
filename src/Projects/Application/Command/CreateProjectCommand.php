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

namespace App\Projects\Application\Command;

use App\Projects\Domain\Model\Project\ProjectId;
use App\Projects\Domain\Model\Project\ProjectName;
use App\Projects\Domain\Model\Project\ProjectPlatform;
use App\Projects\Domain\Model\Project\ProjectUrl;
use App\Shared\Application\Command\CommandInterface;
use App\Users\Domain\Model\User\UserId;

class CreateProjectCommand implements CommandInterface
{
    private ProjectId $id;

    private ProjectName $name;

    private ProjectUrl $url;

    private ProjectPlatform $platform;

    private UserId $userId;

    public function __construct(string $id, string $name, string $url, string $platform, string $userId)
    {
        $this->id = ProjectId::fromString($id);
        $this->name = ProjectName::fromString($name);
        $this->url = ProjectUrl::fromString($url);
        $this->platform = ProjectPlatform::fromString($platform);
        $this->userId = UserId::fromString($userId);
    }

    public function getId(): ProjectId
    {
        return $this->id;
    }

    public function getName(): ProjectName
    {
        return $this->name;
    }

    public function getUrl(): ProjectUrl
    {
        return $this->url;
    }

    public function getPlatform(): ProjectPlatform
    {
        return $this->platform;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
