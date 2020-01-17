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

use App\Shared\Application\Command\CommandInterface;
use App\Users\Domain\Model\UserConfirmationToken;
use App\Users\Domain\Model\UserId;

class ConfirmUserCommand implements CommandInterface
{
    /**
     * @var UserConfirmationToken
     */
    private UserConfirmationToken $token;

    public function __construct(string $token)
    {
        $this->token = UserConfirmationToken::fromString($token);
    }

    /**
     * @return UserConfirmationToken
     */
    public function getToken(): UserConfirmationToken
    {
        return $this->token;
    }
}