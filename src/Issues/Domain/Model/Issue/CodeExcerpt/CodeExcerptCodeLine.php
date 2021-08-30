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

namespace App\Issues\Domain\Model\Issue\CodeExcerpt;

use App\Issues\Domain\Model\Issue\CodeExcerpt;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("app_issue_code_excerpt_line")
 */
class CodeExcerptCodeLine
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Issues\Domain\Model\Issue\CodeExcerpt", inversedBy="lines")
     * @ORM\JoinColumn(name="code_excerpt_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private CodeExcerpt $codeExcerpt;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private int $line;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private string $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $selected;

    public function __construct(CodeExcerpt $codeExcerpt, int $line, string $content, bool $selected)
    {
        $this->codeExcerpt = $codeExcerpt;
        $this->line = $line;
        $this->content = $content;
        $this->selected = $selected;
    }

    public function getLine(): int
    {
        return $this->line;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function isSelected(): bool
    {
        return $this->selected;
    }
}
