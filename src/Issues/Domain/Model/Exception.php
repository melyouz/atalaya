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
    private string $code = '';

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

    /**
     * @ORM\Embedded(class="App\Issues\Domain\Model\File")
     * @var File
     */
    private File $file;

    private function __construct(ExceptionCode $code, ExceptionClass $class, ExceptionMessage $message, File $file)
    {
        $this->code = $code->value();
        $this->class = $class->value();
        $this->message = $message->value();
        $this->file = $file;
    }

    public static function create(ExceptionCode $code, ExceptionClass $class, ExceptionMessage $message, File $file)
    {
        return new self($code, $class, $message, $file);
    }

    public function getCode(): ExceptionCode
    {
        return ExceptionCode::fromString($this->code);
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function getClass(): ExceptionClass
    {
        return ExceptionClass::fromString($this->class);
    }

    public function getClassName(): string
    {
        return basename($this->class);
    }

    public function getMessage(): ExceptionMessage
    {
        return ExceptionMessage::fromString($this->message);
    }
}
