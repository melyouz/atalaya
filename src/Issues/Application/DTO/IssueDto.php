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

namespace App\Issues\Application\DTO;


class IssueDto
{
    /**
     * @var RequestDto
     */
    public RequestDto $request;

    /**
     * @var ExceptionDto
     */
    public ExceptionDto $exception;

    /**
     * @var FileDto
     */
    public FileDto $file;

    /**
     * @var CodeExcerptDto
     */
    public CodeExcerptDto $codeExcerpt;

    /**
     * @var array
     */
    public array $tags = [];

    public function __construct(RequestDto $request, ExceptionDto $exception, FileDto $file, CodeExcerptDto $codeExcerpt, array $tags)
    {
        $this->request = $request;
        $this->exception = $exception;
        $this->file = $file;
        $this->codeExcerpt = $codeExcerpt;
        $this->tags = $tags;
    }
}
