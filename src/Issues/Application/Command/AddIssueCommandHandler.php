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

namespace App\Issues\Application\Command;

use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptId;
use App\Issues\Domain\Model\Issue\CodeExcerpt\CodeExcerptLanguage;
use App\Issues\Domain\Model\Issue\Exception\ExceptionClass;
use App\Issues\Domain\Model\Issue\Exception\ExceptionCode;
use App\Issues\Domain\Model\Issue\Exception\ExceptionMessage;
use App\Issues\Domain\Model\Issue\File\FileLine;
use App\Issues\Domain\Model\Issue\File\FilePath;
use App\Issues\Domain\Model\Issue\Request\RequestMethod;
use App\Issues\Domain\Model\Issue\Request\RequestUrl;
use App\Issues\Domain\Repository\IssueRepositoryInterface;
use App\Projects\Domain\Repository\ProjectRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class AddIssueCommandHandler implements CommandHandlerInterface
{
    /**
     * @var IssueRepositoryInterface
     */
    private IssueRepositoryInterface $issueRepo;

    /**
     * @var ProjectRepositoryInterface
     */
    private ProjectRepositoryInterface $projectRepo;

    public function __construct(IssueRepositoryInterface $issueRepo, ProjectRepositoryInterface $projectRepo)
    {
        $this->issueRepo = $issueRepo;
        $this->projectRepo = $projectRepo;
    }

    public function __invoke(AddIssueCommand $command)
    {
        $this->projectRepo->isProjectTokenValidOrThrow($command->getProjectId(), $command->getProjectToken());

        $issueId = $command->getId();
        $projectId = $command->getProjectId();
        $issueDto = $command->getIssueDto();
        $requestDto = $issueDto->request;
        $exceptionDto = $issueDto->exception;
        $fileDto = $issueDto->file;
        $excerptDto = $issueDto->codeExcerpt;
        $excerptId = uuid_create(UUID_TYPE_RANDOM);

        $issue = new Issue($issueId, $projectId, $issueDto->tags);
        $issue->addRequest(RequestMethod::fromString($requestDto->method), RequestUrl::fromString($requestDto->url), $requestDto->headers);
        $issue->addException(ExceptionCode::fromString($exceptionDto->code), ExceptionClass::fromString($exceptionDto->class), ExceptionMessage::fromString($exceptionDto->message));
        $issue->addFile(FilePath::fromString($fileDto->path), FileLine::fromInteger($fileDto->line));
        $issue->addCodeExcerpt(CodeExcerptId::fromString($excerptId), CodeExcerptLanguage::fromString($excerptDto->lang), $excerptDto->linesToArray());
        $issue->open();

        if (!$issue->isDraft()) {
            $this->issueRepo->save($issue);
        }
    }
}
