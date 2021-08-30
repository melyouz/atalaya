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

namespace Tests\Shared\Infrastructure\Bus;

use App\Shared\Application\Query\QueryInterface;
use App\Shared\Infrastructure\Bus\SymfonyQueryBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyQueryBusTest extends TestCase
{
    public function testDispatch(): void
    {
        $queryMock = $this->createMock(QueryInterface::class);
        $symfonyMessageBusMock = $this->createMock(MessageBusInterface::class);
        $queryBus = new SymfonyQueryBus($symfonyMessageBusMock);

        $handledStampMock = $this->createMock(HandledStamp::class);
        $handledStampMock->expects($this->once())
            ->method('getResult')
            ->willReturn(1337);

        $envelopeMock = $this->createMock(Envelope::class);
        $envelopeMock->expects($this->once())
            ->method('last')
            ->willReturn($handledStampMock);

        $symfonyMessageBusMock->expects($this->once())
            ->method('dispatch')
            ->with($queryMock)
            ->willReturn($envelopeMock);

        $result = $queryBus->query($queryMock);

        $this->assertEquals(1337, $result);
    }
}
