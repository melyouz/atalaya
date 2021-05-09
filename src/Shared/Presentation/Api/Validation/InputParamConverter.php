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

declare(strict_types=1);

namespace App\Shared\Presentation\Api\Validation;

use App\Shared\Presentation\Api\Exception\InputValidationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InputParamConverter implements ParamConverterInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function supports(ParamConverter $configuration)
    {
        if (!$class = $configuration->getClass()) {
            return false;
        }

        return is_subclass_of($class, InputDtoInterface::class);
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $class = $configuration->getClass();
        $name = $configuration->getName();

        try {
            $object = $this->serializer->deserialize($request->getContent(), $class, 'json');
            $request->attributes->set($name, $object);
            $request->attributes->set('validationErrors', []);

            $this->validationGuard($object);
        } catch (InputValidationException $e) {
            $request->attributes->set('validationErrors', $e->getViolations());
        }
    }

    private function validationGuard($object)
    {
        $violations = $this->validator->validate($object);

        if (count($violations) > 0) {
            $simplifiedViolations = [];
            foreach ($violations as $violation) {
                $simplifiedViolations[] = [
                    'path' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                    'invalidValue' => $violation->getInvalidValue(),
                ];
            }

            throw new InputValidationException($simplifiedViolations);
        }
    }
}
