<?php

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
