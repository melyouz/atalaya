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

namespace App\Users\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\Exception\UserRoleNotAssignedException;
use App\Users\Domain\Repository\UserRepositoryInterface;

class DemoteUserFromAdminCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke(DemoteUserFromAdminCommand $command): void
    {
        try {
            $user = $this->userRepo->get($command->getId());
            $user->demoteFromAdmin();
            $this->userRepo->save($user);
        } catch (UserNotFoundException $e) {
            // noop
        } catch (UserRoleNotAssignedException $e) {
            // noop
        }
    }
}
