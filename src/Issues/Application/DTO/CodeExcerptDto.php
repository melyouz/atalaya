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

namespace App\Issues\Application\DTO;

class CodeExcerptDto
{
    public string $lang;

    /**
     * @var CodeLineDto[]
     */
    public array $lines;

    public function __construct(string $lang, array $lines)
    {
        $this->lang = $lang;
        $this->lines = $lines;
    }

    public function linesToArray(): array
    {
        return array_map(function (CodeLineDto $lineDto) {
            return [
                'line' => $lineDto->line,
                'content' => $lineDto->content,
                'selected' => $lineDto->selected,
            ];
        }, $this->lines);
    }
}
