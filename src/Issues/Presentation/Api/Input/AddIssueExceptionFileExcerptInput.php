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

use App\Issues\Domain\Model\Issue\Exception\ExceptionFile\ExceptionFileCodeLine;
use App\Issues\Domain\Model\Issue\Exception\ExceptionFile\ExceptionFileExcerpt;
use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddIssueExceptionFileExcerptInput implements InputDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @var string
     */
    public string $lang;

    /**
     * @Assert\All({
     *      @Assert\Type("App\Issues\Presentation\Api\Input\AddIssueExceptionFileExcerptCodeLineInput")
     * })
     * @Assert\Valid
     * @var AddIssueExceptionFileExcerptCodeLineInput[]
     */
    public array $lines;

    public function toDomainObject(): ExceptionFileExcerpt
    {
        $codeLines = array_map(function(AddIssueExceptionFileExcerptCodeLineInput $line) {
            return $line->toDomainObject();
        }, $this->lines);

        return ExceptionFileExcerpt::create($this->lang, $codeLines);
    }
}
