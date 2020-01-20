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
use App\Shared\Application\Bus\QueryBusInterface;
use App\Shared\Application\Command\CommandInterface;
use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractController
{
    public const FORMAT_JSON = 'json';

    private CommandBusInterface $commandBus;
    private QueryBusInterface $queryBus;
    private SerializerInterface $serializer;

    public function __construct(CommandBusInterface $commandBus, QueryBusInterface $queryBus, SerializerInterface $serializer)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->serializer = $serializer;
    }

    protected function dispatch(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }

    /**
     * @param QueryInterface $query
     * @return mixed
     */
    protected function query(QueryInterface $query)
    {
        return $this->queryBus->query($query);
    }

    protected function uuid(): string
    {
        return uuid_create(UUID_TYPE_RANDOM);
    }

    protected function validationErrorResponse(array $validationErrors): JsonResponse
    {
        return new JsonResponse(['validationErrors' => $validationErrors], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @param array|object $data
     * @return JsonResponse
     */
    protected function toJsonResponse($data): JsonResponse
    {
        $content = $this->serializer->serialize($data, self::FORMAT_JSON);

        return JsonResponse::fromJsonString($content);
    }
}
