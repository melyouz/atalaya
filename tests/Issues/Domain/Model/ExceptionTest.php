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

namespace Tests\Issues\Domain\Model;

use App\Issues\Domain\Model\Issue\Exception;
use App\Issues\Domain\Model\Issue\Exception\ExceptionClass;
use App\Issues\Domain\Model\Issue\Exception\ExceptionMessage;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    /**
     * @var Exception
     */
    private Exception $exception;

    protected function setUp(): void
    {
        $exceptionClass = 'App\Whatever\Class';
        $exceptionMessage = 'Error: Call to undefined function notExistingFunction()';
        $this->exception = Exception::create(ExceptionClass::fromString($exceptionClass), ExceptionMessage::fromString($exceptionMessage));
    }

    public function testHasClass(): void
    {
        $this->assertInstanceOf(ExceptionClass::class, $this->exception->getClass());
        $this->assertEquals('App\Whatever\Class', $this->exception->getClass()->value());
    }

    public function testHasMessage(): void
    {
        $this->assertInstanceOf(ExceptionMessage::class, $this->exception->getMessage());
        $this->assertEquals('Error: Call to undefined function notExistingFunction()', $this->exception->getMessage());
    }

}
