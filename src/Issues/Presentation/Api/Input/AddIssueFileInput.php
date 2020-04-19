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

use App\Issues\Application\DTO\FileDto;
use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddIssueFileInput implements InputDtoInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @var string
     */
    public string $path;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("int")
     * @Assert\Positive()
     * @var int
     */
    public int $line;

    public function toDto(): FileDto
    {
        return new FileDto($this->path, $this->line);
    }
}
