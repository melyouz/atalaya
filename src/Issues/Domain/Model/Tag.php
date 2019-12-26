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

class Tag
{
    private string $issueId;
    private string $name;
    private string $value;

    private function __construct(IssueId $issueId, TagName $name, TagValue $value)
    {
        $this->issueId = $issueId->value();
        $this->name = $name->value();
        $this->value = $value->value();
    }

    public static function create(IssueId $issueId, TagName $name, TagValue $value)
    {
        return new self($issueId, $name, $value);
    }

    public function getName(): TagName
    {
        return TagName::fromString($this->name);
    }

    public function getValue(): TagValue
    {
        return TagValue::fromString($this->value);
    }

    /**
     * url https://localhost:8000/hello-there
     *
     * browser Chrome 78.0.3904
     * browser.name Chrome
     * browser.version 78.0.3904
     *
     * runtime php 7.3.4
     * runtime.name php
     * runtime.version 7.3.4
     *
     * os Windows NT 10.0
     * os.name Windows NT
     * os.version 10.0 (build 18363 (Windows 10))
     * os.kernel_version Windows NT HOSTNAME 10.0 build 18363 (Windows 10) AMD64
     *
     * client_os.name Windows 10
     * client_os.version
     *
     * environment dev
     *
     * server_name SERVERNAME
     *
     * level error
     */
}
