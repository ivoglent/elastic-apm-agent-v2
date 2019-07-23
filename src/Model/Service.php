<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/23/19
 * Time: 3:13 PM
 */

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Service extends BaseObject
{
    /**
     * Name and version of the Elastic APM agent
     *
     * @var  Agent
     */
    private $agent;

    /**
     * Name and version of the web framework used
     *
     * @var Framework
     */
    private $framework;

    /**
     * Name and version of the programming language used
     *
     * @var Language
     */
    private $language;

    /**
     * Immutable name of the service emitting this event
     *
     * @var string
     */
    private $name;

    /**
     * Environment name of the service, e.g. "production" or "staging"
     *
     * @var string
     */
    private $environment;

    /**
     * Name and version of the language runtime running this service
     *
     * @var Runtime
     */
    private $runtime;

    /**
     * Version of the service emitting this event
     *
     * @var string
     */
    private $version;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'agent' => $this->agent,
            'framework' => $this->framework,
            'language' => $this->language,
            'name' => $this->name,
            'environment' => $this->environment,
            'runtime' => $this->runtime,
            'version' => $this->version
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