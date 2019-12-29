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

namespace App\Issues\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Exception
{
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $class;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $message;

    private function __construct(ExceptionClass $class, ExceptionMessage $message)
    {
        $this->class = $class->value();
        $this->message = $message->value();
    }

    public static function create(ExceptionClass $class, ExceptionMessage $message)
    {
        return new self($class, $message);
    }

    public function getClass(): ExceptionClass
    {
        return ExceptionClass::fromString($this->class);
    }

    public function getMessage(): ExceptionMessage
    {
        return ExceptionMessage::fromString($this->message);
    }
}
