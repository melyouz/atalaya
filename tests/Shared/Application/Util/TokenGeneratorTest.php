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

namespace Tests\Shared\Application\Util;

use App\Shared\Application\Util\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{
    private TokenGenerator $tokenGenerator;

    public function testRandomToken()
    {
        $a = $this->tokenGenerator->randomToken(64);
        $b = $this->tokenGenerator->randomToken(64);
        $this->assertEquals(64, strlen($a));
        $this->assertEquals(64, strlen($b));
        $this->assertNotEquals($a, $b);
    }

    public function testMd5RandomToken()
    {
        $a = $this->tokenGenerator->md5RandomToken();
        $b = $this->tokenGenerator->md5RandomToken();
        $this->assertEquals(32, strlen($a));
        $this->assertEquals(32, strlen($b));
        $this->assertNotEquals($a, $b);
    }

    protected function setUp(): void
    {
        $this->tokenGenerator = new TokenGenerator();
    }
}
