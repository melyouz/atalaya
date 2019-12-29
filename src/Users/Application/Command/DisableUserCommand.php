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
use App\Users\Domain\Model\UserId;

class DisableUserCommand implements CommandInterface
{
    /**
     * @var UserId
     */
    private UserId $id;

    public function __construct(string $id)
    {
        $this->id = UserId::fromString($id);
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }
}
