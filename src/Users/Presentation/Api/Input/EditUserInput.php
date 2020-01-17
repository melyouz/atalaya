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

namespace App\Users\Presentation\Api\Input;

use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class EditUserInput implements InputDtoInterface
{
    /**
     * @Assert\Length(max="255")
     */
    public ?string $name = null;

    /**
     * @Assert\Email()
     * @Assert\Length(max="255")
     */
    public ?string $email = null;

    /**
     * @Assert\Length(max="255")
     */
    public ?string $password = null;
}
