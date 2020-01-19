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

namespace Tests\Shared\Presentation\Api\Controller;

use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Bus\QueryBusInterface;
use App\Shared\Application\Command\CommandInterface;
use App\Shared\Presentation\Api\Controller\AbstractController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AbstractControllerTest extends TestCase
{
    public function testDispatch(): void
    {
        $commandBusMock = $this->createMock(CommandBusInterface::class);
        $queryBusMock = $this->createMock(QueryBusInterface::class);
        $serializerMock = $this->createMock(Serializer::class);
        $commandMock = $this->createMock(CommandInterface::class);

        $commandBusMock->expects($this->once())
            ->method('dispatch')
            ->with($commandMock);

        $controller = new FakeController($commandBusMock, $queryBusMock, $serializerMock);
        $controller->dispatch($commandMock);
    }

    public function testValidationErrorResponse(): void
    {
        $commandBusMock = $this->createMock(CommandBusInterface::class);
        $queryBusMock = $this->createMock(QueryBusInterface::class);
        $serializerMock = $this->createMock(Serializer::class);
        $validationsErrors = [['path' => 'age', 'message' => 'Invalid value "test"']];
        $expectedContent = '{"validationErrors":[{"path":"age","message":"Invalid value \u0022test\u0022"}]}';
        $expectedStatusCode = JsonResponse::HTTP_BAD_REQUEST;

        $controller = new FakeController($commandBusMock, $queryBusMock, $serializerMock);
        $result = $controller->validationErrorResponse($validationsErrors);

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals($expectedContent, $result->getContent());
        $this->assertEquals($expectedStatusCode, $result->getStatusCode());
    }

    public function testUuid(): void
    {
        $commandBusMock = $this->createMock(CommandBusInterface::class);
        $queryBusMock = $this->createMock(QueryBusInterface::class);
        $serializerMock = $this->createMock(Serializer::class);
        $controller = new FakeController($commandBusMock, $queryBusMock, $serializerMock);
        $uuidRegex = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
        $uuid1 = $controller->uuid();
        $uuid2 = $controller->uuid();

        $this->assertRegExp($uuidRegex, $uuid1);
        $this->assertRegExp($uuidRegex, $uuid2);
        $this->assertNotEquals($uuid1, $uuid2);
    }
}

class FakeController extends AbstractController
{
    public function dispatch(CommandInterface $command): void
    {
        parent::dispatch($command);
    }

    public function validationErrorResponse(array $validationErrors): JsonResponse
    {
        return parent::validationErrorResponse($validationErrors);
    }

    public function uuid(): string
    {
        return parent::uuid();
    }
}
