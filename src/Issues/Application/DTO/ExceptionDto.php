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

class ExceptionDto
{
    public string $code;

    public string $class;

    public string $message;

    public function __construct(string $code, string $class, string $message)
    {
        $this->code = $code;
        $this->class = $class;
        $this->message = $message;
    }
}
