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
    protected $raw;

    /**
     * The protocol of the request, e.g. 'https:'.
     *
     * @var string
     */
    protected $protocol;

    /**
     * The full, possibly agent-assembled URL of the request, e.g https://example.com:443/search?q=elasticsearch#top
     *
     * @var string
     */
    protected $full;

    /**
     * The hostname of the request, e.g. 'example.com'.
     *
     * @var string
     */
    protected $hostname;

    /**
     * The port of the request, e.g. '443
     *
     * @var int
     */
    protected $port;

    /**
     * The path of the request, e.g. '/search
     *
     * @var string
     */
    protected $pathname;

    /**
     * The search describes the query string of the request. It is expected to have values delimited by ampersands.
     *
     * @var string
     */
    protected $search;

    /**
     * The hash of the request URL, e.g. 'top'
     *
     * @var string
     */
    protected $hash;

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
            'hash' => $this->hash,
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
