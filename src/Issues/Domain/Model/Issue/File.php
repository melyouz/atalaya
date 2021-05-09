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

namespace App\Issues\Domain\Model\Issue;

use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\File\FileLine;
use App\Issues\Domain\Model\Issue\File\FilePath;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("app_issue_file")
 */
class File
{
    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue")
     * @ORM\JoinColumn(name="issue_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * @var Issue
     */
    private Issue $issue;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $path;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private int $line;

    public function __construct(Issue $issue, FilePath $path, FileLine $line)
    {
        $this->issue = $issue;
        $this->path = $path->value();
        $this->line = $line->value();
    }

    public function getPath(): FilePath
    {
        return FilePath::fromString($this->path);
    }

    public function getLine(): FileLine
    {
        return FileLine::fromInteger($this->line);
    }
}
