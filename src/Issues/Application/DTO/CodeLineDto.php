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


class CodeLineDto
{
    /**
     * @var int
     */
    public int $line;

    /**
     * @var string
     */
    public string $content;

    /**
     * @var bool
     */
    public bool $selected;

    public function __construct(int $line, string $content, bool $selected)
    {
        $this->line = $line;
        $this->content = $content;
        $this->selected = $selected;
    }
}
