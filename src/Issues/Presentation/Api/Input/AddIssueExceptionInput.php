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

use App\Issues\Application\DTO\ExceptionDto;
use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddIssueExceptionInput implements InputDtoInterface
{
    /**
     * @Assert\Length(max="255")
     */
    public string $code;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    public string $class;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    public string $message;

    public function toDto(): ExceptionDto
    {
        return new ExceptionDto($this->code, $this->class, $this->message);
    }
}
