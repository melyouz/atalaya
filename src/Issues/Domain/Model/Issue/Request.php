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

declare(strict_types=1);

namespace App\Issues\Domain\Model\Issue;

use App\Issues\Domain\Model\Issue;
use App\Issues\Domain\Model\Issue\Request\RequestMethod;
use App\Issues\Domain\Model\Issue\Request\RequestUrl;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("app_issue_request")
 */
class Request
{
    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Issues\Domain\Model\Issue")
     * @ORM\JoinColumn(name="issue_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private Issue $issue;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private string $method;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @ORM\Column(type="array")
     */
    private array $headers = [];

    public function __construct(Issue $issue, RequestMethod $method, RequestUrl $url, array $headers = [])
    {
        $this->issue = $issue;
        $this->method = $method->value();
        $this->url = $url->value();
        $this->headers = $headers;
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::fromString($this->method);
    }

    public function getUrl(): RequestUrl
    {
        return RequestUrl::fromString($this->url);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
