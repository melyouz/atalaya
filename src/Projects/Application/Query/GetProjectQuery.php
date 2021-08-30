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

use App\Projects\Domain\Model\Project\ProjectId;
use App\Shared\Application\Query\QueryInterface;

class GetProjectQuery implements QueryInterface
{
    private ProjectId $id;

    public function __construct(string $id)
    {
        $this->id = ProjectId::fromString($id);
    }

    public function getId(): ProjectId
    {
        return $this->id;
    }
}
