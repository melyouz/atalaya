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

namespace App\Issues\Presentation\Api\Input;

use App\Issues\Application\DTO\CodeExcerptDto;
use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddIssueCodeExcerptInput implements InputDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @var string
     */
    public string $lang;

    /**
     * @Assert\All({
     *      @Assert\Type("App\Issues\Presentation\Api\Input\AddIssueCodeExcerptCodeLineInput")
     * })
     * @Assert\Valid
     * @var AddIssueCodeExcerptCodeLineInput[]
     */
    public array $lines;

    public function toDto(): CodeExcerptDto
    {
        $lines = array_map(function (AddIssueCodeExcerptCodeLineInput $codeLine) {
            return $codeLine->toDto();
        }, $this->lines);

        return new CodeExcerptDto($this->lang, $lines);
    }
}
