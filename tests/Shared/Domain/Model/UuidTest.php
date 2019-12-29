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

namespace Tests\Projects\Domain\Model;

use App\Shared\Domain\Model\Uuid;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    /**
     * @dataProvider nonUuidProvider
     * @param string $fakeUuid
     */
    public function testNonUuidProjectIdShouldFail(string $fakeUuid): void
    {
        $this->expectException(InvalidArgumentException::class);
        Uuid::fromString($fakeUuid);
    }

    /**
     * @dataProvider uuidProvider
     * @param string $uuid
     */
    public function testUuidProjectIdShouldPass(string $uuid): void
    {
        $projectId = Uuid::fromString($uuid);
        $this->assertEquals($uuid, $projectId->value());
    }

    public function nonUuidProvider(): array
    {
        return [
            [''],
            ['test'],
            ['5180cbac-0340-46f5-b106e6ee0b34b9970'],
            ['5180cbac_0340-46f5-b106-e6ee0b34b997'],
        ];
    }

    public function uuidProvider(): array
    {
        return [
            ['5180cbac-0340-46f5-b106-e6ee0b34b997'],
            ['88d907f5-870b-4e43-9f99-62b9ac153c0b'],
        ];
    }
}
