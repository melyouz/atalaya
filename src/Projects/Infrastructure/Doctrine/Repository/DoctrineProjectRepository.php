<?php

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