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

declare(strict_types=1);

namespace App\Shared\Presentation\Api\Exception;

use Exception;

class InputValidationException extends Exception
{
    /**
     * @var array
     */
    private array $violations;

    public function __construct(array $violations)
    {
        $this->violations = $violations;
        parent::__construct('Validation Exception. Use ::getViolations for more details.');
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}
