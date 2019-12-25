<?php


namespace Tests\Projects\Domain\Model;


use App\Projects\Domain\Model\ProjectId;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProjectIdTest extends TestCase
{
    /**
     * @dataProvider nonUuidProvider
     * @param string $fakeUuid
     */
    public function testNonUuidProjectIdShouldFail(string $fakeUuid): void
    {
        $this->expectException(InvalidArgumentException::class);
        ProjectId::fromString($fakeUuid);
    }

    /**
     * @dataProvider uuidProvider
     * @param string $uuid
     */
    public function testUuidProjectIdShouldPass(string $uuid): void
    {
        $projectId = ProjectId::fromString($uuid);
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
