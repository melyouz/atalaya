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

use App\Issues\Domain\Model\Exception;
use App\Issues\Domain\Model\ExceptionClass;
use App\Issues\Domain\Model\ExceptionCode;
use App\Issues\Domain\Model\ExceptionMessage;
use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddIssueExceptionInput implements InputDtoInterface
{
    /**
     * @Assert\Length(max="255")
     * @var string
     */
    public string $code;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @var string
     */
    public string $class;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @var string
     */
    public string $message;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("App\Issues\Presentation\Api\Input\AddIssueExceptionFileInput")
     * @Assert\Valid()
     * @var AddIssueExceptionFileInput
     */
    public AddIssueExceptionFileInput $file;

    public function toDomainObject(): Exception
    {
        $file = $this->file->toDomainObject();

        return Exception::create(ExceptionCode::fromString($this->code), ExceptionClass::fromString($this->class), ExceptionMessage::fromString($this->message), $file);
    }
}
