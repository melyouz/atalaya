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

declare(strict_types=1);

namespace App\Issues\Presentation\Api\Input;

use App\Issues\Domain\Model\Issue\Exception\ExceptionFile\FileCodeLine;
use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddIssueExceptionFileExcerptCodeLineInput implements InputDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("int")
     * @Assert\Positive()
     * @var int
     */
    public int $line;

    /**
     * @Assert\Length(max="1024")
     * @var string
     */
    public string $content;

    /**
     * @Assert\NotNull()
     * @Assert\Type("bool")
     * @var bool
     */
    public bool $selected;

    public function toDomainObject(): FileCodeLine
    {
        return FileCodeLine::create($this->line, $this->content, $this->selected);
    }
}
