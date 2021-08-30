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

namespace App\Issues\Application\Command;

use App\Issues\Domain\Model\Issue\IssueId;
use App\Shared\Application\Command\CommandInterface;

class PinIssueCommand implements CommandInterface
{
    private IssueId $id;

    public function __construct(string $id)
    {
        $this->id = IssueId::fromString($id);
    }

    public function getId(): IssueId
    {
        return $this->id;
    }
}
