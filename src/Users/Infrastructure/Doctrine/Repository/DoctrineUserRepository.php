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

namespace App\Users\Infrastructure\Doctrine\Repository;

use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\Model\User;
use App\Users\Domain\Model\UserConfirmationToken;
use App\Users\Domain\Model\UserEmail;
use App\Users\Domain\Model\UserId;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $em;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->repo = $entityManager->getRepository(User::class);
    }

    /**
     * @inheritDoc
     */
    public function get(UserId $id): User
    {
        if (!$user = $this->repo->find($id->value())) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getByEmail(UserEmail $email): User
    {
        if (!$user = $this->repo->findOneBy(['email' => $email->value()])) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getByToken(UserConfirmationToken $token): User
    {
        if (!$user = $this->repo->findOneBy(['confirmationToken' => $token->value()])) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function emailExists(UserEmail $email): bool
    {
        return (bool) $this->repo->findOneBy(['email' => $email->value()]);
    }

    /**
     * @inheritDoc
     */
    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
