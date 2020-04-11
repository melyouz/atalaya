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

namespace App\Issues\Domain\Model\Issue\Exception;

use App\Issues\Domain\Model\Issue\Exception\ExceptionFile\ExceptionFileExcerpt;
use App\Issues\Domain\Model\Issue\Exception\ExceptionFile\ExceptionFileLine;
use App\Issues\Domain\Model\Issue\Exception\ExceptionFile\ExceptionFilePath;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class ExceptionFile
{
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $path;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private int $line;

    /**
     * @ORM\Embedded(class="App\Issues\Domain\Model\Issue\Exception\ExceptionFile\ExceptionFileExcerpt")
     * @var ExceptionFileExcerpt
     */
    private ExceptionFileExcerpt $excerpt;

    private function __construct(ExceptionFilePath $path, ExceptionFileLine $line, ExceptionFileExcerpt $excerpt)
    {
        $this->path = $path->value();
        $this->line = $line->value();
        $this->excerpt = $excerpt;
    }

    public static function create(ExceptionFilePath $path, ExceptionFileLine $line, ExceptionFileExcerpt $excerpt)
    {
        return new self($path, $line, $excerpt);
    }

    public function getPath(): ExceptionFilePath
    {
        return ExceptionFilePath::fromString($this->path);
    }

    public function getLine(): ExceptionFileLine
    {
        return ExceptionFileLine::fromInteger($this->line);
    }

    public function getExcerpt(): ExceptionFileExcerpt
    {
        return $this->excerpt;
    }
}
