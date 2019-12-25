<?php

declare(strict_types=1);

namespace App\Projects\Presentation\Api\Action;
use Symfony\Component\Validator\Constraints as Assert;

use App\Projects\Application\Command\EditProjectCommand;
use App\Shared\Presentation\Http\Validation\ActionInterface;

class EditProjectAction implements ActionInterface
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

    public function toCommand(): EditProjectCommand
    {
        return new EditProjectCommand(uuid_create(UUID_TYPE_RANDOM), $this->name, $this->url);
    }
}
