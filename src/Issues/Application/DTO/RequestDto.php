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


class RequestDto
{
    /**
     * @var string
     */
    public string $method;

    /**
     * @var string
     */
    public string $url;

    /**
     * @var array
     */
    public array $headers = [];

    public function __construct(string $method, string $url, array $headers)
    {
        $this->method = $method;
        $this->url = $url;
        $this->headers = $headers;
    }
}
