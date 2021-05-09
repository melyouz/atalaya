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

namespace Tests\Shared\Presentation\Api\Controller;

use App\Security\Application\AuthServiceInterface;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use App\Shared\Application\Command\CommandInterface;
use App\Shared\Application\Query\QueryInterface;
use App\Shared\Presentation\Api\Controller\AbstractController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;

class AbstractControllerTest extends TestCase
{
    public function testDispatch(): void
    {
        $commandBusMock = $this->createMock(CommandBusInterface::class);
        $queryBusMock = $this->createMock(QueryBusInterface::class);
        $serializerMock = $this->createMock(Serializer::class);
        $authServiceMock = $this->createMock(AuthServiceInterface::class);
        $commandMock = $this->createMock(CommandInterface::class);

        $commandBusMock->expects($this->once())
            ->method('dispatch')
            ->with($commandMock);

        $controller = new FakeController($commandBusMock, $queryBusMock, $serializerMock, $authServiceMock);
        $controller->dispatch($commandMock);
    }

    public function testQuery(): void
    {
        $commandBusMock = $this->createMock(CommandBusInterface::class);
        $queryBusMock = $this->createMock(QueryBusInterface::class);
        $serializerMock = $this->createMock(Serializer::class);
        $authServiceMock = $this->createMock(AuthServiceInterface::class);
        $queryMock = $this->createMock(QueryInterface::class);

        $queryBusMock->expects($this->once())
            ->method('query')
            ->with($queryMock);

        $controller = new FakeController($commandBusMock, $queryBusMock, $serializerMock, $authServiceMock);
        $controller->query($queryMock);
    }

    public function testUuid(): void
    {
        $commandBusMock = $this->createMock(CommandBusInterface::class);
        $queryBusMock = $this->createMock(QueryBusInterface::class);
        $serializerMock = $this->createMock(Serializer::class);
        $authServiceMock = $this->createMock(AuthServiceInterface::class);
        $controller = new FakeController($commandBusMock, $queryBusMock, $serializerMock, $authServiceMock);
        $uuidRegex = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
        $uuid1 = $controller->uuid();
        $uuid2 = $controller->uuid();

        $this->assertRegExp($uuidRegex, $uuid1);
        $this->assertRegExp($uuidRegex, $uuid2);
        $this->assertNotEquals($uuid1, $uuid2);
    }

    public function testValidationErrorResponse(): void
    {
        $commandBusMock = $this->createMock(CommandBusInterface::class);
        $queryBusMock = $this->createMock(QueryBusInterface::class);
        $serializerMock = $this->createMock(Serializer::class);
        $authServiceMock = $this->createMock(AuthServiceInterface::class);
        $validationsErrors = [['path' => 'age', 'message' => 'Invalid value "test"']];
        $expectedContent = '{"validationErrors":[{"path":"age","message":"Invalid value \u0022test\u0022"}]}';
        $expectedStatusCode = JsonResponse::HTTP_BAD_REQUEST;

        $controller = new FakeController($commandBusMock, $queryBusMock, $serializerMock, $authServiceMock);
        $result = $controller->validationErrorResponse($validationsErrors);

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals($expectedContent, $result->getContent());
        $this->assertEquals($expectedStatusCode, $result->getStatusCode());
    }

    public function testToJsonResponse(): void
    {
        $commandBusMock = $this->createMock(CommandBusInterface::class);
        $queryBusMock = $this->createMock(QueryBusInterface::class);
        $serializerMock = $this->createMock(Serializer::class);
        $authServiceMock = $this->createMock(AuthServiceInterface::class);
        $controller = new FakeController($commandBusMock, $queryBusMock, $serializerMock, $authServiceMock);

        $serializerMock->expects($this->once())
            ->method('serialize')
            ->willReturn('{"name":"John Doe","age":27}');

        $object = (object)['name' => 'John Doe', 'age' => 27];
        $result = $controller->toJsonResponse($object);

        $this->assertEquals(json_encode($object), $result->getContent());
        $this->assertEquals(JsonResponse::HTTP_OK, $result->getStatusCode());
    }
}

class FakeController extends AbstractController
{
    public function dispatch(CommandInterface $command): void
    {
        parent::dispatch($command);
    }

    public function query(QueryInterface $query): ?object
    {
        return parent::query($query);
    }

    public function uuid(): string
    {
        return parent::uuid();
    }

    public function validationErrorResponse(array $validationErrors): JsonResponse
    {
        return parent::validationErrorResponse($validationErrors);
    }

    public function toJsonResponse($data): JsonResponse
    {
        return parent::toJsonResponse($data);
    }
}
