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

use App\Issues\Application\DTO\RequestDto;
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
     */
    public string $url;

    /**
     * @Assert\Collection()
     */
    public array $headers = [];

    public function toDto(): RequestDto
    {
        return new RequestDto($this->method, $this->url, $this->headers);
    }
}
