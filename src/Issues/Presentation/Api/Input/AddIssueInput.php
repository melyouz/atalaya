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

use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddIssueInput implements InputDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("App\Issues\Presentation\Api\Input\AddIssueRequestInput")
     * @Assert\Valid()
     * @var AddIssueRequestInput
     */
    public AddIssueRequestInput $request;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("App\Issues\Presentation\Api\Input\AddIssueExceptionInput")
     * @Assert\Valid()
     * @var AddIssueExceptionInput
     */
    public AddIssueExceptionInput $exception;

    /**
     * @Assert\Collection()
     * @var array
     */
    public array $tags = [];
}
