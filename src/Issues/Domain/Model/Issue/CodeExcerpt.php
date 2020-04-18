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

namespace App\Issues\Domain\Model\Issue;

use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptCodeLine;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptId;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptLanguage;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("app_issue_code_excerpt")
 */
class CodeExcerpt
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36)
     * @var string
     */
    private string $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue")
     * @ORM\JoinColumn(name="issue_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * @var string
     */
    private string $issueId;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $lang;

    /**
     * @ORM\OneToMany(targetEntity="App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptCodeLine", mappedBy="codeExcerptId")
     * @var CodeExcerptCodeLine[]
     */
    private array $lines;

    private function __construct(CodeExcerptId $id, IssueId $issueId, CodeExcerptLanguage $lang)
    {
        $this->id = $id->value();
        $this->issueId = $issueId->value();
        $this->lang = $lang->value();
    }

    /**
     * @param CodeExcerptId $id
     * @param IssueId $issueId
     * @param CodeExcerptLanguage $lang
     * @return static
     */
    public static function create(CodeExcerptId $id, IssueId $issueId, CodeExcerptLanguage $lang): self
    {
        return new self($id, $issueId, $lang);
    }

    public function addLinesFromArray(array $codeLines): void
    {
        $this->lines = array_map(function($codeLine) {
            return CodeExcerptCodeLine::create($this->getId(), $codeLine['line'], $codeLine['content'], $codeLine['selected']);
        }, $codeLines);
    }

    /**
     * @return CodeExcerptId
     */
    public function getId(): CodeExcerptId
    {
        return CodeExcerptId::fromString($this->id);
    }

    /**
     * @return CodeExcerptLanguage
     */
    public function getLang(): CodeExcerptLanguage
    {
        return CodeExcerptLanguage::fromString($this->lang);
    }

    /**
     * @return CodeExcerptCodeLine[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }
}
