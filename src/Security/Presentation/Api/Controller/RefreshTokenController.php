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

namespace App\Security\Presentation\Api\Controller;

use App\Security\Application\JwtGeneratorInterface;
use App\Security\Application\JwtValidatorInterface;
use App\Shared\Presentation\Api\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RefreshTokenController extends AbstractController
{
    public const HEADER_AUTHORIZATION = 'Authorization';

    public function __invoke(Request $request, JwtGeneratorInterface $jwtGenerator, JwtValidatorInterface $jwtValidator)
    {
        $token = $request->headers->get(self::HEADER_AUTHORIZATION);

        if (!$jwtValidator->fromBearerAuthorizationHeader($token)) {
            return new Response('', Response::HTTP_UNAUTHORIZED);
        }

        $newToken = $jwtGenerator->forUser($this->getLoggedInUser());

        return new JsonResponse(['token' => $newToken]);
    }
}
