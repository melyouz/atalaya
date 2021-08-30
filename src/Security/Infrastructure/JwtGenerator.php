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

namespace App\Security\Infrastructure;

use App\Security\Application\JwtGeneratorInterface;
use App\Users\Domain\Model\User;
use DateInterval;
use DateTimeImmutable;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JwtGenerator implements JwtGeneratorInterface
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private JwtConfiguratorInterface $jwtConfigurator
    ) {
    }

    /**
     * @inheritDoc
     */
    public function forUser(User $user): string
    {
        $issuedAt = new DateTimeImmutable();
        $expiresIn = (int) $this->parameterBag->get('app_jwt_expires_in');
        $expiresAt = $issuedAt->add(new DateInterval(sprintf('PT%dH', $expiresIn)));
        $signer = $this->jwtConfigurator->signer();
        $privateKey = $this->jwtConfigurator->signingKey();

        $builder = $this->jwtConfigurator->builder();
        $token = $builder
            ->relatedTo($user->getId()->value())
            ->issuedAt($issuedAt)
            ->expiresAt($expiresAt)
            ->withClaim('user_name', $user->getName())
            ->withClaim('user_email', $user->getEmail())
            ->withClaim('user_roles', $user->getRoles())
            ->getToken($signer, $privateKey);

        return $token->toString();
    }
}
