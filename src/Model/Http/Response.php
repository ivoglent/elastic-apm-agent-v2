<?php

namespace Elastic\Apm\PhpAgent\Model\Http;

use Elastic\Apm\PhpAgent\Util\BaseObject;

class Response extends BaseObject
{
    /**
     * A boolean indicating whether the response was finished or not
     *
     * @var bool
     */
    protected $finished;

    /**
     * A mapping of HTTP headers of the response object
     *
     * @var object
     */
    protected $headers;

    /**
     * @var bool
     */
    protected $headers_sent;

    /**
     * @var int
     */
    protected $status_code;

    /**
     * @param bool $finished
     */
    public function setFinished(bool $finished)
    {
        $this->finished = $finished;
    }

    /**
     * @param object $headers
     */
    public function setHeaders(object $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param bool $headers_sent
     */
    public function setHeadersSent(bool $headers_sent)
    {
        $this->headers_sent = $headers_sent;
    }

    /**
     * @param int $status_code
     */
    public function setStatusCode(int $status_code)
    {
        $this->status_code = $status_code;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'finished' => $this->finished,
            'headers' => (object) $this->headers,
            'headers_sent' => $this->headers_sent,
            'status_code' => $this->status_code,
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
            'types' => [
                'status_code' => 'integer',
                'finished' => 'boolean',
            ],
        ];
    }
}
