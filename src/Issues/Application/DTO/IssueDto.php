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

namespace App\Issues\Application\DTO;

class IssueDto
{
    public RequestDto $request;

    public ExceptionDto $exception;

    public FileDto $file;

    public CodeExcerptDto $codeExcerpt;

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
