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

use App\Issues\Domain\Model\Issue\Request;
use App\Issues\Domain\Model\Issue\Request\RequestMethod;
use App\Issues\Domain\Model\Issue\Request\RequestUrl;
use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddIssueRequestInput implements InputDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({"GET", "POST", "PUT", "PATCH", "DELETE"})
     */
    public string $method;

    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     * @Assert\Length(max="255")
     * @var string
     */
    public string $url;

    /**
     * @Assert\Collection()
     * @var array
     */
    public array $headers = [];

    public function toDomainObject(): Request
    {
        return Request::create(RequestMethod::fromString($this->method), RequestUrl::fromString($this->url), $this->headers);
    }
}
