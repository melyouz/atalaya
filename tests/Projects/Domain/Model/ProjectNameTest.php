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

use App\Projects\Domain\Model\ProjectName;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProjectNameTest extends TestCase
{
    /**
     * @dataProvider validNamesProvider
     * @param string $name
     */
    public function testNameUpTo80CharsShouldPass(string $name): void
    {
        $projectName = ProjectName::fromString($name);
        $this->assertEquals($name, $projectName->value());
    }

    /**
     * @dataProvider invalidNamesProvider
     * @param string $invalidName
     */
    public function testNameOver80CharsShouldFail(string $invalidName): void
    {
        $this->expectException(InvalidArgumentException::class);
        ProjectName::fromString($invalidName);
    }

    public function testNameBlankShouldFail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ProjectName::fromString('');
    }

    public function validNamesProvider(): array
    {
        return [
            ['My awesome project v1'],
            ['my-other-project-i-care-about'],
            ['Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec lobortis, sapien.'],
        ];
    }

    public function invalidNamesProvider(): array
    {
        return [
            ['Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec lobortis, sapien ac fermentum blandit'],
        ];
    }
}
