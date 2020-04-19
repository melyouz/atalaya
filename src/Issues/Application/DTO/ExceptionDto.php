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


class ExceptionDto
{
    /**
     * @var string
     */
    public string $code;

    /**
     * @var string
     */
    public string $class;

    /**
     * @var string
     */
    public string $message;

    public function __construct(string $code, string $class, string $message)
    {
        $this->code = $code;
        $this->class = $class;
        $this->message = $message;
    }
}
