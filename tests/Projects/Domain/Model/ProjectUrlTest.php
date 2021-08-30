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

namespace Tests\Projects\Domain\Model;

use App\Projects\Domain\Model\Project\ProjectUrl;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProjectUrlTest extends TestCase
{
    /**
     * @dataProvider validUrlsProvider
     */
    public function testUrlValidShouldPass(string $url): void
    {
        $projectUrl = ProjectUrl::fromString($url);
        $this->assertEquals($url, $projectUrl->value());
    }

    /**
     * @dataProvider invalidUrlsProvider
     */
    public function testUrlIncorrectShouldFail(string $invalidUrl): void
    {
        $this->expectException(InvalidArgumentException::class);
        ProjectUrl::fromString($invalidUrl);
    }

    public function testUrlBlankShouldFail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ProjectUrl::fromString('');
    }

    public function validUrlsProvider(): array
    {
        return [
            ['https://whatever.dev'],
            ['https://whatever-awesome-project.dev'],
            ['http://whatever-awesome-project.dev'],
        ];
    }

    public function invalidUrlsProvider(): array
    {
        return [
            ['whatever-awesome-project.dev'],
            ['https://whatever-awesome-project-with-over-80-chars-url.lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-varius'],
        ];
    }
}
