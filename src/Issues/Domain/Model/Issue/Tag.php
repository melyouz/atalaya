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

use App\Issues\Domain\Model\Issue\Tag\TagName;
use App\Issues\Domain\Model\Issue\Tag\TagValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("app_issue_tag")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Issues\Domain\Model\Issue", inversedBy="tags")
     * @ORM\JoinColumn(name="issue_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * @var string
     */
    private string $issueId;

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $value;

    private function __construct(IssueId $issueId, TagName $name, TagValue $value)
    {
        $this->issueId = $issueId->value();
        $this->name = $name->value();
        $this->value = $value->value();
    }

    public static function create(IssueId $issueId, TagName $name, TagValue $value)
    {
        return new self($issueId, $name, $value);
    }

    public function getName(): TagName
    {
        return TagName::fromString($this->name);
    }

    public function getValue(): TagValue
    {
        return TagValue::fromString($this->value);
    }
}
