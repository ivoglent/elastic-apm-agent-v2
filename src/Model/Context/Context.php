<?php
namespace Elastic\Apm\PhpAgent\Model\Context;


use Elastic\Apm\PhpAgent\Model\Http\Response;
use Elastic\Apm\PhpAgent\Model\Service;
use Elastic\Apm\PhpAgent\Model\Tag;
use Elastic\Apm\PhpAgent\Model\User;
use Elastic\Apm\PhpAgent\Util\BaseObject;

class Context extends BaseObject
{
    /**
     * An arbitrary mapping of additional metadata to store with the event.
     *
     * @var object
     */
    protected $custom;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Response
     */
    protected $request;

    /**
     * @var Tag
     */
    protected $tags;

    /**
     * Describes the correlated user for this event. If user data are provided here, all user related information from metadata is ignored, otherwise the metadata's user information will be stored with the event.
     *
     * @var User
     */
    protected $user;

    /**
     * @var object
     */
    protected $page;

    /**
     * Service related information can be sent per event. Provided information will override the more generic information from metadata, non provided fields will be set according to the metadata information.
     *
     * @var Service
     */
    protected $service;


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'custom' => $this->custom,
            'response' => $this->response,
            'request' => $this->request,
            'tags' => $this->tags,
            'user' => $this->user,
            'page' => $this->page,
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