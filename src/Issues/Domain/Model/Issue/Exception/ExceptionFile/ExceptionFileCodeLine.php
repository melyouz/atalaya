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

namespace App\Issues\Domain\Model\Issue\Exception\ExceptionFile;

use Serializable;

class ExceptionFileCodeLine implements Serializable
{
    /**
     * @var int
     */
    private int $line;

    /**
     * @var string
     */
    private string $content;

    /**
     * @var bool
     */
    private bool $selected;

    private function __construct(int $line, string $content, bool $selected)
    {
        $this->line = $line;
        $this->content = $content;
        $this->selected = $selected;
    }

    public static function create(int $line, string $content, bool $selected): self
    {
        return new self($line, $content, $selected);
    }

    /**
     * @return int
     */
    public function getLine(): int
    {
        return $this->line;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return bool
     */
    public function isSelected(): bool
    {
        return $this->selected;
    }

    public function toArray(): array
    {
        return [
            'line' => $this->line,
            'content' => $this->content,
            'selected' => $this->selected,
        ];
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        foreach($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
