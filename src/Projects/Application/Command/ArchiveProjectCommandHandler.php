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

use App\Projects\Domain\Exception\ProjectAlreadyArchivedException;
use App\Projects\Domain\Exception\ProjectNotFoundException;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class ArchiveProjectCommandHandler implements CommandHandlerInterface
{
    private ProjectRepositoryInterface $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function __invoke(ArchiveProjectCommand $command)
    {

        try {
            $project = $this->projectRepo->get($command->getId());
            $project->archive();
            $this->projectRepo->save($project);
        } catch (ProjectNotFoundException $e) {
            // noop
        } catch (ProjectAlreadyArchivedException $e) {
            // noop
        }
    }
}
