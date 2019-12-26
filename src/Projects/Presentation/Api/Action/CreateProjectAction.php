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

namespace App\Projects\Presentation\Api\Action;

use App\Projects\Application\Command\CreateProjectCommand;
use App\Shared\Presentation\Http\Validation\ActionInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateProjectAction implements ActionInterface
{
    /**
     * @Assert\NotBlank()
     */
    public string $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    public string $url;

    public function toCommand(): CreateProjectCommand
    {
        return new CreateProjectCommand(uuid_create(UUID_TYPE_RANDOM), $this->name, $this->url);
    }
}
