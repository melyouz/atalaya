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

use App\Projects\Domain\Model\ProjectId;
use App\Shared\Application\Query\QueryInterface;

class GetProjectQuery implements QueryInterface
{
    /**
     * @var ProjectId
     */
    private ProjectId $id;

    public function __construct(string $id)
    {
        $this->id = ProjectId::fromString($id);
    }

    /**
     * @return ProjectId
     */
    public function getId(): ProjectId
    {
        return $this->id;
    }
}
