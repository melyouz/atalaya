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

namespace App\Projects\Presentation\Api\Input;

use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class EditProjectInput implements InputDtoInterface
{
    /**
     * @Assert\Length(max="80")
     */
    public ?string $name = null;

    /**
     * @Assert\Url()
     * @Assert\Length(max="80")
     */
    public ?string $url = null;

    /**
     * @Assert\Length(max="30")
     */
    public ?string $platform = null;
}
