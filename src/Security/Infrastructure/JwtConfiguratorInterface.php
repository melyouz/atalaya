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

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Validation\Constraint;
use Lcobucci\JWT\Validator;

interface JwtConfiguratorInterface
{
    public function builder(): Builder;

    public function parser(): Parser;

    public function signer(): Signer;

    public function signingKey(): Key;

    public function verificationKey(): Key;

    public function validator(): Validator;

    /** @return Constraint[] */
    public function validationConstraints(): array;
}
