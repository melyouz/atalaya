<?php

declare(strict_types=1);

namespace App\Projects\Presentation\Api\Controller;

use App\Projects\Presentation\Api\Action\CreateProjectAction;
use App\Shared\Application\Bus\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class PostProjectController
{
    private SerializerInterface $serializer;
    /**
     * @var CommandBusInterface
     */
    private CommandBusInterface $commandBus;

    public function __construct(SerializerInterface $serializer, CommandBusInterface $commandBus)
    {
        $this->serializer = $serializer;
        $this->commandBus = $commandBus;
    }

    public function __invoke(CreateProjectAction $newProject, array $validationErrors): JsonResponse
    {
        if (count($validationErrors)) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize(['validationErrors' => $validationErrors], 'json'),
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $this->commandBus->dispatch($newProject->toCommand());

        return JsonResponse::fromJsonString($this->serializer->serialize($newProject, 'json'));
    }
}
