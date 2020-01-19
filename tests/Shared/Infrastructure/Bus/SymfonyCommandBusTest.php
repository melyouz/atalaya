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

namespace Tests\Shared\Infrastructure\Bus;

use App\Shared\Application\Command\CommandInterface;
use App\Shared\Infrastructure\Bus\SymfonyCommandBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyCommandBusTest extends TestCase
{
    public function testDispatch(): void
    {
        $commandMock = $this->createMock(CommandInterface::class);
        $symfonyMessageBusMock = $this->createMock(MessageBusInterface::class);
        $symfonyMessageBusMock->expects($this->once())
            ->method('dispatch')
            ->with($commandMock)
            ->willReturn(new Envelope($commandMock));

        $commandBus = new SymfonyCommandBus($symfonyMessageBusMock);
        $commandBus->dispatch($commandMock);
    }
}
