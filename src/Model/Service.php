<?php

namespace Elastic\Apm\PhpAgent\Model;

use Elastic\Apm\PhpAgent\Util\BaseObject;

class Service extends BaseObject
{
    /**
     * Name and version of the Elastic APM agent
     *
     * @var  Agent
     */
    protected $agent;

    /**
     * Name and version of the web framework used
     *
     * @var Framework
     */
    protected $framework;

    /**
     * Name and version of the programming language used
     *
     * @var Language
     */
    protected $language;

    /**
     * Immutable name of the service emitting this event
     *
     * @var string
     */
    protected $name;

    /**
     * Environment name of the service, e.g. "production" or "staging"
     *
     * @var string
     */
    protected $environment;

    /**
     * Name and version of the language runtime running this service
     *
     * @var Runtime
     */
    protected $runtime;

    /**
     * Version of the service emitting this event
     *
     * @var string
     */
    protected $version;

    /**
     * @param Agent $agent
     */
    public function setAgent(Agent $agent)
    {
        $this->agent = $agent;
    }

    /**
     * @param Framework $framework
     */
    public function setFramework(Framework $framework)
    {
        $this->framework = $framework;
    }

    /**
     * @param Language $language
     */
    public function setLanguage(Language $language)
    {
        $this->language = $language;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $environment
     */
    public function setEnvironment(string $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @param Runtime $runtime
     */
    public function setRuntime(Runtime $runtime)
    {
        $this->runtime = $runtime;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

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
            'version' => $this->version,
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
