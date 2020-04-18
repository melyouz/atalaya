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
     * @var string
     */
    private string $issueId;

    /**
     * @ORM\Column(type="string", length=6)
     * @var string
     */
    private string $method;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $url;

    /**
     * @ORM\Column(type="array")
     * @var array
     */
    private array $headers = [];

    private function __construct(IssueId $issueId, RequestMethod $method, RequestUrl $url, array $headers = [])
    {
        $this->issueId = $issueId->value();
        $this->method = $method->value();
        $this->url = $url->value();
        $this->headers = $headers;
    }

    public static function create(IssueId $issueId, RequestMethod $method, RequestUrl $url, array $headers = [])
    {
        return new self($issueId, $method, $url, $headers);
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
