<?php
/**
 *
 * @copyright 2020 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

declare(strict_types=1);

namespace App\Shared\Presentation\Api\Controller;

use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class AbstractController
{
    private SerializerInterface $serializer;
    private CommandBusInterface $commandBus;

    public function __construct(SerializerInterface $serializer, CommandBusInterface $commandBus)
    {
        $this->serializer = $serializer;
        $this->commandBus = $commandBus;
    }

    protected function dispatch(CommandInterface $command)
    {
        $this->commandBus->dispatch($command);
    }

    protected function validationErrorResponse(array $validationErrors): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(['validationErrors' => $validationErrors], 'json'),
            JsonResponse::HTTP_BAD_REQUEST
        );
    }

    protected function uuid(): string
    {
        return uuid_create(UUID_TYPE_RANDOM);
    }
}
