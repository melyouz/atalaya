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

use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class EditProjectCommandHandler implements CommandHandlerInterface
{
    private ProjectRepositoryInterface $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function __invoke(EditProjectCommand $command)
    {
        $project = $this->projectRepo->get($command->getId());

        if ($command->getName() && !$project->getName()->sameValueAs($command->getName())) {
            $project->changeName($command->getName());
        }

        if ($command->getUrl() && !$project->getUrl()->sameValueAs($command->getUrl())) {
            $project->changeUrl($command->getUrl());
        }

        if ($command->getPlatform() && !$project->getPlatform()->sameValueAs($command->getPlatform())) {
            $project->changePlatform($command->getPlatform());
        }

        $this->projectRepo->save($project);
    }
}
