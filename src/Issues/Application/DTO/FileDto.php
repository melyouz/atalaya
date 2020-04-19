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

namespace App\Issues\Application\DTO;


class FileDto
{
    /**
     * @var string
     */
    public string $path;

    /**
     * @var int
     */
    public int $line;

    public function __construct(string $path, int $line)
    {
        $this->path = $path;
        $this->line = $line;
    }
}
