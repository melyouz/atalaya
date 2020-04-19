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
     * @var CodeExcerpt
     */
    private CodeExcerpt $codeExcerpt;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @var int
     */
    private int $line;

    /**
     * @ORM\Column(type="string", length=1024)
     * @var string
     */
    private string $content;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private bool $selected;

    private function __construct(CodeExcerpt $codeExcerpt, int $line, string $content, bool $selected)
    {
        $this->codeExcerpt = $codeExcerpt;
        $this->line = $line;
        $this->content = $content;
        $this->selected = $selected;
    }

    public static function create(CodeExcerpt $codeExcerpt, int $line, string $content, bool $selected): self
    {
        return new self($codeExcerpt, $line, $content, $selected);
    }

    /**
     * @return int
     */
    public function getLine(): int
    {
        return $this->line;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return bool
     */
    public function isSelected(): bool
    {
        return $this->selected;
    }
}
