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

use App\Issues\Application\DTO\IssueDto;
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
     * @Assert\NotBlank()
     * @Assert\Type("App\Issues\Presentation\Api\Input\AddIssueFileInput")
     * @Assert\Valid()
     * @var AddIssueFileInput
     */
    public AddIssueFileInput $file;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("App\Issues\Presentation\Api\Input\AddIssueCodeExcerptInput")
     * @Assert\Valid()
     * @var AddIssueCodeExcerptInput
     */
    public AddIssueCodeExcerptInput $codeExcerpt;

    /**
     * @Assert\Collection()
     * @var array
     */
    public array $tags = [];

    public function toDto(): IssueDto
    {
        return new IssueDto($this->request->toDto(), $this->exception->toDto(), $this->file->toDto(), $this->codeExcerpt->toDto(), $this->tags);
    }
}
