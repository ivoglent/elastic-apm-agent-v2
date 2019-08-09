<?php

namespace Elastic\Apm\PhpAgent\Model\Http;

use Elastic\Apm\PhpAgent\Util\BaseObject;

class Request extends BaseObject
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $method;

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $urlParts = parse_url($url);
        $this->url = new Url([
            'raw' => $url,
            'protocol' => $urlParts['schema'] ?? 'http',
            'full' => $url,
            'hostname' => $urlParts['hostname'] ?? '',
            'port' => $urlParts['port'] ?? 80,
            'pathname' => $urlParts['path'] ?? '',
            'search' => $urlParts['query'] ?? '',
            'hash' => $urlParts['fragment'] ?? ''
        ]);
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }



    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'method' => $this->method
        ];
    }

    /**
     * Define object validation rules
     *
     * @return array
     */
    public function validationRules(): array
    {
        return [
            'required' => ['url', 'method']
        ];
    }
}
