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

namespace Tests\Shared\Domain\Model;


use App\Shared\Domain\Model\AbstractValueObject;
use PHPUnit\Framework\TestCase;

class AbstractValueObjectTest extends TestCase
{
    public function testToString(): void
    {
        $valueObjectMock = $this->getMockForAbstractClass(AbstractValueObject::class);
        $valueObjectMock->expects($this->any())
            ->method('value')
            ->willReturn('test-value');

        $this->assertEquals('test-value', (string) $valueObjectMock);
    }

    public function testSameValueAs(): void
    {
        $valueObjectMock1 = $this->getMockForAbstractClass(AbstractValueObject::class);
        $valueObjectMock1->expects($this->any())
            ->method('value')
            ->willReturn('test-value');

        $valueObjectMock2 = $this->getMockForAbstractClass(AbstractValueObject::class);
        $valueObjectMock2->expects($this->any())
            ->method('value')
            ->willReturn('test-value');

        $valueObjectMock3 = $this->getMockForAbstractClass(AbstractValueObject::class);
        $valueObjectMock3->expects($this->any())
            ->method('value')
            ->willReturn('test-value-different');

        $this->assertTrue($valueObjectMock1->sameValueAs($valueObjectMock2));
        $this->assertFalse($valueObjectMock1->sameValueAs($valueObjectMock3));
    }
}
