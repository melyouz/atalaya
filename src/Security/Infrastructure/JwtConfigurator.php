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

use DateTimeZone;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Validation\Constraint;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JwtConfigurator implements JwtConfiguratorInterface
{
    private Configuration $configuration;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $privateKeyPath = (string) $parameterBag->get('app_jwt_private_key');
        $publicKeyPath = (string) $parameterBag->get('app_jwt_public_key');

        $signer = new Sha256();
        $privateKey = InMemory::file($privateKeyPath);
        $publicKey = InMemory::file($publicKeyPath);
        $this->configuration = Configuration::forAsymmetricSigner($signer, $privateKey, $publicKey);

        $signedWith = new SignedWith($this->signer(), $this->verificationKey());
        $validAt = new LooseValidAt(new SystemClock(new DateTimeZone('Europe/Madrid')));
        $this->configuration->setValidationConstraints($signedWith, $validAt);
    }

    public function signer(): Signer
    {
        return $this->configuration->signer();
    }

    public function verificationKey(): Key
    {
        return $this->configuration->verificationKey();
    }

    public function builder(): Builder
    {
        return $this->configuration->builder();
    }

    public function parser(): Parser
    {
        return $this->configuration->parser();
    }

    public function signingKey(): Key
    {
        return $this->configuration->signingKey();
    }

    public function validator(): Validator
    {
        return $this->configuration->validator();
    }

    /** @return Constraint[] */
    public function validationConstraints(): array
    {
        return $this->configuration->validationConstraints();
    }
}
