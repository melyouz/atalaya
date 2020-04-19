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

use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptCodeLine;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptId;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptLanguage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @var Issue
     */
    private Issue $issue;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $lang;

    /**
     * @ORM\OneToMany(targetEntity="App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptCodeLine", mappedBy="codeExcerpt", cascade={"persist", "remove"})
     * @var CodeExcerptCodeLine[]|Collection
     */
    private Collection $lines;

    private function __construct(CodeExcerptId $id, Issue $issue, CodeExcerptLanguage $lang, array $rawCodeLines)
    {
        $this->id = $id->value();
        $this->issue = $issue;
        $this->lang = $lang->value();
        $this->lines = new ArrayCollection();

        foreach ($rawCodeLines as $rawCodeLine) {
            $this->lines->add(CodeExcerptCodeLine::create($this, $rawCodeLine['line'], $rawCodeLine['content'], $rawCodeLine['selected']));
        }
    }

    /**
     * @param CodeExcerptId $id
     * @param Issue $issue
     * @param CodeExcerptLanguage $lang
     * @param array $rawCodeLines
     * @return static
     */
    public static function create(CodeExcerptId $id, Issue $issue, CodeExcerptLanguage $lang, array $rawCodeLines): self
    {
        return new self($id, $issue, $lang, $rawCodeLines);
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
