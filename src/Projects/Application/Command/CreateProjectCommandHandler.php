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

use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\Project\ProjectToken;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Util\TokenGenerator;

class CreateProjectCommandHandler implements CommandHandlerInterface
{
    private ProjectRepositoryInterface $projectRepo;

    private TokenGenerator $tokenGenerator;

    public function __construct(ProjectRepositoryInterface $projectRepo, TokenGenerator $tokenGenerator)
    {
        $this->projectRepo = $projectRepo;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function __invoke(CreateProjectCommand $command)
    {
        $projectToken = ProjectToken::fromString($this->tokenGenerator->md5RandomToken());
        $project = new Project($command->getId(), $command->getName(), $command->getUrl(), $projectToken, $command->getPlatform(), $command->getUserId());

        $this->projectRepo->save($project);
    }
}
