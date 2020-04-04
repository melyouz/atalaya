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

use App\Issues\Domain\Model\CodeLine;
use App\Issues\Domain\Model\FileExcerpt;
use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddIssueExceptionFileExcerpt implements InputDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @var string
     */
    public string $lang;

    /**
     * @Assert\All({
     *      @Assert\Type("App\Issues\Presentation\Api\Input\AddIssueExceptionFileCodeLineInput")
     * })
     * @Assert\Valid
     * @var AddIssueExceptionFileCodeLineInput[]
     */
    public array $lines;

    public function toDomainObject(): FileExcerpt
    {
        $codeLines = array_map(function(AddIssueExceptionFileCodeLineInput $line) {
            return $line->toDomainObject();
        }, $this->lines);

        return FileExcerpt::create($this->lang, $codeLines);
    }
}
