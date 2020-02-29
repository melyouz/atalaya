<?php
/**
 *
 * @copyright 2020 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

declare(strict_types=1);

namespace App\Security\Infrastructure;

use App\Security\Application\JwtGeneratorInterface;
use App\Users\Domain\Model\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JwtGenerator implements JwtGeneratorInterface
{
    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * @inheritDoc
     */
    public function forUser(User $user): string
    {
        $signer = new Sha256();
        $privateKey = new Key(file_get_contents($this->parameterBag->get('app_jwt_private_key')));
        $time = time();

        $builder = new Builder();
        $token = $builder
            ->relatedTo($user->getId()->value())
            ->issuedAt($time)
            ->expiresAt($time + 28800) // 8H
            ->withClaim('roles', $user->getRoles())
            ->getToken($signer, $privateKey);

        return $token->__toString();
    }
}
