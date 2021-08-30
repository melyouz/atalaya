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

namespace App\Users\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use App\Users\Domain\Model\User\UserConfirmationToken;

class ConfirmUserCommand implements CommandInterface
{
    private UserConfirmationToken $token;

    public function __construct(string $token)
    {
        $this->token = UserConfirmationToken::fromString($token);
    }

    public function getToken(): UserConfirmationToken
    {
        return $this->token;
    }
}
