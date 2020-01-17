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

namespace Tests\Shared\Presentation\Http\Validation;

use App\Shared\Application\Command\CommandInterface;
use App\Shared\Presentation\Api\Validation\InputDtoInterface;
use App\Shared\Presentation\Api\Validation\InputParamConverter;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InputParamConverterTest extends TestCase
{
    public function testSupports()
    {
        $serializerMock = $this->createMock(SerializerInterface::class);
        $validatorMock = $this->createMock(ValidatorInterface::class);
        $paramConverter = new InputParamConverter($serializerMock, $validatorMock);
        $commandMock = $this->createMock(CommandInterface::class);
        $actionMock = $this->createMock(InputDtoInterface::class);

        $this->assertFalse($paramConverter->supports(new ParamConverter(['class' => get_class($commandMock)])));
        $this->assertTrue($paramConverter->supports(new ParamConverter(['class' => get_class($actionMock)])));
        $this->assertFalse($paramConverter->supports(new ParamConverter([])));
    }

    public function testApply()
    {
        $serializerMock = $this->createMock(SerializerInterface::class);
        $validatorMock = $this->createMock(ValidatorInterface::class);
        $actionMock = $this->createMock(InputDtoInterface::class);

        $validatorMock->expects($this->at(0))
            ->method('validate')
            ->willReturn([]);

        $validatorMock->expects($this->at(1))
            ->method('validate')
            ->willReturn([new ConstraintViolation('Awesome descriptive message', '', [], 'original value', 'name', 'original value')]);

        $paramConverter = new InputParamConverter($serializerMock, $validatorMock);

        $configuration = new ParamConverter(['class' => get_class($actionMock), 'name' => 'whateverAction']);
        $content = '{"name": "Awesome project"}';
        $request = new Request([], [], [], [], [], [], $content);

        $paramConverter->apply($request, $configuration);
        $this->assertTrue($request->attributes->has('whateverAction'));
        $this->assertTrue($request->attributes->has('validationErrors'));
        $this->assertEmpty($request->attributes->get('validationErrors'));

        $paramConverter->apply($request, $configuration);
        $this->assertCount(1, $request->attributes->get('validationErrors'));
    }
}
