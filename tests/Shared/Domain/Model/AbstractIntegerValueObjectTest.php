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

namespace Tests\Shared\Domain\Model;


use App\Shared\Domain\Model\AbstractIntegerValueObject;
use PHPUnit\Framework\TestCase;

class AbstractIntegerValueObjectTest extends TestCase
{
    public function testToString(): void
    {
        $valueObjectMock = $this->getMockForAbstractClass(AbstractIntegerValueObject::class, [], '', false, true, true, ['value']);
        $valueObjectMock->expects($this->any())
            ->method('value')
            ->willReturn(1337);

        $this->assertEquals('1337', (string)$valueObjectMock);
    }

    public function testSameValueAs(): void
    {
        $valueObjectMock1 = $this->getMockForAbstractClass(AbstractIntegerValueObject::class, [], '', false, true, true, ['value']);
        $valueObjectMock1->expects($this->any())
            ->method('value')
            ->willReturn(1337);

        $valueObjectMock2 = $this->getMockForAbstractClass(AbstractIntegerValueObject::class, [], '', false, true, true, ['value']);
        $valueObjectMock2->expects($this->any())
            ->method('value')
            ->willReturn(1337);

        $valueObjectMock3 = $this->getMockForAbstractClass(AbstractIntegerValueObject::class, [], '', false, true, true, ['value']);
        $valueObjectMock3->expects($this->any())
            ->method('value')
            ->willReturn(1338);

        $this->assertTrue($valueObjectMock1->sameValueAs($valueObjectMock2));
        $this->assertFalse($valueObjectMock1->sameValueAs($valueObjectMock3));
    }

    public function testJsonSerialize(): void
    {
        $valueObjectMock = $this->getMockForAbstractClass(AbstractIntegerValueObject::class, [], '', false, true, true, ['value']);
        $valueObjectMock->expects($this->once())
            ->method('value')
            ->willReturn(1337);

        $this->assertEquals('1337', $valueObjectMock->jsonSerialize());
    }
}
