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

declare(strict_types=1);

namespace App\Projects\Application\Query;

use App\Shared\Application\Query\QueryInterface;
use App\Users\Domain\Model\User\UserId;

class GetProjectsByUserIdQuery implements QueryInterface
{
    private UserId $userId;

    public function __construct(string $userId)
    {
        $this->userId = UserId::fromString($userId);
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
