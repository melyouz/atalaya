<?php
/**
 *
 * @copyright 2020 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

declare(strict_types=1);

namespace App\Projects\Application\Query;

use App\Shared\Application\Query\QueryInterface;
use App\Users\Domain\Model\UserId;

class GetProjectsByUserIdQuery implements QueryInterface
{
    /**
     * @var UserId
     */
    private UserId $userId;

    public function __construct(string $userId)
    {
        $this->userId = UserId::fromString($userId);
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
