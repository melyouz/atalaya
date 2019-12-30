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

namespace App\Issues\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Request
{
    /**
     * @ORM\Column(type="string", length=6)
     * @var string
     */
    private string $method;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $url;

    /**
     * @ORM\Column(type="array")
     * @var array
     */
    private array $headers = [];

    private function __construct(RequestMethod $method, RequestUrl $url)
    {
        $this->method = $method->value();
        $this->url = $url->value();
    }

    public static function create(RequestMethod $method, RequestUrl $url, array $headers = [])
    {
        $request = new self($method, $url);

        if (!empty($headers)) {
            $request->addHeadersFromArray($headers);
        }

        return $request;
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::fromString($this->method);
    }

    public function getUrl(): RequestUrl
    {
        return RequestUrl::fromString($this->url);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    private function addHeadersFromArray(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }
}
