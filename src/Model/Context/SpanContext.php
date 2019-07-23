<?php
namespace Elastic\Apm\PhpAgent\Model\Context;


use Elastic\Apm\PhpAgent\Model\Service;
use Elastic\Apm\PhpAgent\Model\Tag;
use Elastic\Apm\PhpAgent\Util\BaseObject;

class SpanContext extends BaseObject
{
    /**
     * An object containing contextual data for database spans
     *
     * @var DbContext
     */
    private $db;

    /**
     * An object containing contextual data of the related http request.
     *
     * @var HttpContext
     */
    private $http;

    /**
     * @var Tag
     */
    private $tags;

    /**
     * @var Service
     */
    private $service;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'db' => $this->db,
            'http' => $this->http,
            'tags' => $this->tags,
            'service' => $this->service
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