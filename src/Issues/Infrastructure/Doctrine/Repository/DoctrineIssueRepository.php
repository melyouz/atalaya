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

namespace App\Issues\Infrastructure\Doctrine\Repository;

use App\Issues\Domain\Exception\IssueNotFoundException;
use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\IssueId;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Projects\Domain\Model\ProjectId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class DoctrineIssueRepository implements IssueRepositoryInterface
{
    private EntityManagerInterface $em;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->repo = $entityManager->getRepository(Issue::class);
    }

    /**
     * @inheritDoc
     */
    public function get(IssueId $id): Issue
    {
        /** @var Issue|null $issue */
        $issue = $this->repo->find($id->value());

        if (!$issue) {
            throw new IssueNotFoundException();
        }

        return $issue;
    }

    /**
     * @inheritDoc
     */
    public function findAllByProjectId(ProjectId $projectId): array
    {
        return $this->repo->findBy(['projectId' => $projectId->value()]);
    }

    /**
     * @inheritDoc
     */
    public function save(Issue $issue): void
    {
        $this->em->persist($issue);
        $this->em->flush();
    }
}
