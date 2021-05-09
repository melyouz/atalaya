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

namespace Tests\Shared\Presentation\Http\Exception;

use App\Shared\Presentation\Api\Exception\InputValidationException;
use PHPUnit\Framework\TestCase;

class InputValidationExceptionTest extends TestCase
{
    public function testGetViolations()
    {
        $violations = ['one', 'two'];
        $exception = new InputValidationException($violations);
        $this->assertEquals($violations, $exception->getViolations());
    }
}
