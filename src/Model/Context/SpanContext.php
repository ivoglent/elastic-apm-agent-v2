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
    protected $db;

    /**
     * An object containing contextual data of the related http request.
     *
     * @var HttpContext
     */
    protected $http;

    /**
     * @var Tag
     */
    protected $tags;

    /**
     * @var Service
     */
    protected $service;

    /**
     * @return DbContext
     */
    public function getDb(): ?DbContext
    {
        return $this->db;
    }

    /**
     * @param DbContext $db
     */
    public function setDb(DbContext $db)
    {
        $this->db = $db;
    }

    /**
     * @return HttpContext
     */
    public function getHttp(): ?HttpContext
    {
        return $this->http;
    }

    /**
     * @param HttpContext $http
     */
    public function setHttp(HttpContext $http)
    {
        $this->http = $http;
    }

    /**
     * @return Tag
     */
    public function getTags(): ?Tag
    {
        return $this->tags;
    }

    /**
     * @param Tag $tags
     */
    public function setTags(Tag $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return Service
     */
    public function getService(): Service
    {
        return $this->service;
    }

    /**
     * @param Service $service
     */
    public function setService(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'db' => $this->db,
            'http' => $this->http,
            'tags' => $this->tags,
            'service' => $this->service,
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
