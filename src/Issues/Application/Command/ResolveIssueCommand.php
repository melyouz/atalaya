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

namespace App\Issues\Application\Command;

use App\Issues\Domain\Model\IssueId;
use App\Shared\Application\Command\CommandInterface;

class ResolveIssueCommand implements CommandInterface
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
