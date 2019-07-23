<?php


namespace Elastic\Apm\PhpAgent\Model\Context;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class HttpContext extends BaseObject
{
    /**
     * The raw url of the correlating http request.
     *
     * @var string
     */
    private $url;

    /**
     * The method of the http request.
     *
     * @var string
     */
    private $method;

    /**
     * The status code of the http request.
     *
     * @var integer
     */
    private $status_code;

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
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
            'url' => $this->url,
            'method' => $this->method,
            'status_code' => $this->status_code
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
            'required' => ['url', 'method', 'status_code'],
            'types' => [
                'status_code' => 'integer'
            ]
        ];
    }
}