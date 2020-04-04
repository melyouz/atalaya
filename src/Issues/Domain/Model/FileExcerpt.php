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
class FileExcerpt
{
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $lang;

    /**
     * @ORM\Column(type="array")
     * @var CodeLine[]
     */
    private array $lines;

    private function __construct(string $lang, array $lines)
    {
        $this->lang = $lang;
        $this->lines = $lines;
    }

    public static function create(string $lang, array $lines): self
    {
        return new self($lang, $lines);
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @return CodeLine[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }
}
