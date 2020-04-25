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

namespace App\Issues\Domain\Model\Issue;

use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\Exception\ExceptionClass;
use App\Issues\Domain\Model\Issue\Exception\ExceptionCode;
use App\Issues\Domain\Model\Issue\Exception\ExceptionMessage;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("app_issue_exception")
 */
class Exception
{
    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue")
     * @ORM\JoinColumn(name="issue_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * @var Issue
     */
    private Issue $issue;

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

    public function __construct(Issue $issue, ExceptionCode $code, ExceptionClass $class, ExceptionMessage $message)
    {
        $this->issue = $issue;
        $this->code = $code->value();
        $this->class = $class->value();
        $this->message = $message->value();
    }

    public function getCode(): ExceptionCode
    {
        return ExceptionCode::fromString($this->code);
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
