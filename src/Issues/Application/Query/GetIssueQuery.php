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

namespace App\Issues\Application\Query;

use App\Issues\Domain\Model\Issue\IssueId;
use App\Shared\Application\Query\QueryInterface;

class GetIssueQuery implements QueryInterface
{
    /**
     * @var IssueId
     */
    private IssueId $id;

    public function __construct(string $id)
    {
        $this->id = IssueId::fromString($id);
    }

    /**
     * @return IssueId
     */
    public function getId(): IssueId
    {
        return $this->id;
    }
}
