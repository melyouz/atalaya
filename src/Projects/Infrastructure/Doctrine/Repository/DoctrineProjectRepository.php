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

use App\Projects\Domain\Exception\InvalidProjectTokenException;
use App\Projects\Domain\Exception\ProjectNotFoundException;
use App\Projects\Domain\Model\Project;
use App\Projects\Domain\Model\ProjectId;
use App\Projects\Domain\Model\ProjectToken;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Users\Domain\Model\UserId;
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

    /**
     * @inheritDoc
     */
    public function findAllByUserId(UserId $userId): array
    {
        return $this->repo->findBy(['userId' => $userId->value()], ['createdAt' => 'desc']);
    }

    /**
     * @inheritDoc
     * @throws InvalidProjectTokenException
     * @throws ProjectNotFoundException
     */
    public function isProjectTokenValidOrThrow(ProjectId $id, ProjectToken $token): bool
    {
        $project = $this->get($id);

        if (!$project->getToken()->sameValueAs($token)) {
            throw new InvalidProjectTokenException();
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function get(ProjectId $id): Project
    {
        /** @var Project|null $project */
        $project = $this->repo->find($id->value());

        if (!$project) {
            throw new ProjectNotFoundException();
        }

        return $project;
    }

    /**
     * @inheritDoc
     */
    public function save(Project $project): void
    {
        $this->em->persist($project);
        $this->em->flush();
    }
}
