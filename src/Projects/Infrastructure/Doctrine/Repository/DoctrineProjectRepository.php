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

namespace App\Projects\Infrastructure\Doctrine\Repository;

use App\Projects\Domain\Exception\ProjectNotFoundException;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class DoctrineProjectRepository implements ProjectRepositoryInterface
{
    private EntityManagerInterface $em;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->repo = $entityManager->getRepository(Project::class);
    }

    public function get(ProjectId $id): Project
    {
        if (!$project = $this->repo->find($id->value())) {
            throw new ProjectNotFoundException();
        }

        return $project;
    }

    public function save(Project $project): void
    {
        $this->em->persist($project);
    }
}
