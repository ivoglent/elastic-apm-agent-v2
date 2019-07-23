<?php


namespace Elastic\Apm\PhpAgent\Model\Http;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Url extends BaseObject
{
    /**
     * The raw, unparsed URL of the HTTP request line, e.g https://example.com:443/search?q=elasticsearch. This URL may be absolute or relative. For more details, see https://www.w3.org/Protocols/rfc2616/rfc2616-sec5.html#sec5.1.2.
     *
     * @var string
     */
    private $raw;

    /**
     * The protocol of the request, e.g. 'https:'.
     *
     * @var string
     */
    private $protocol;

    /**
     * The full, possibly agent-assembled URL of the request, e.g https://example.com:443/search?q=elasticsearch#top
     *
     * @var string
     */
    private $full;

    /**
     * The hostname of the request, e.g. 'example.com'.
     *
     * @var string
     */
    private $hostname;

    /**
     * The port of the request, e.g. '443
     *
     * @var integer
     */
    private $port;

    /**
     * The path of the request, e.g. '/search
     *
     * @var string
     */
    private $pathname;

    /**
     * The search describes the query string of the request. It is expected to have values delimited by ampersands.
     *
     * @var string
     */
    private $search;

    /**
     * The hash of the request URL, e.g. 'top'
     *
     * @var string
     */
    private $hash;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'raw' => $this->raw,
            'protocol' => $this->protocol,
            'full' => $this->full,
            'hostname' => $this->hostname,
            'port' => $this->port,
            'pathname' => $this->pathname,
            'search' => $this->search,
            'hash' => $this->hash
        ];
    }

    /**
     * Define object validation rules
     *
     * @return array
     */
    public function validationRules(): array
    {
        return [];
    }
}