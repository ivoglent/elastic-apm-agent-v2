<?php

namespace Elastic\Apm\PhpAgent\Model;

use Elastic\Apm\PhpAgent\Config;
use Elastic\Apm\PhpAgent\Interfaces\ConfigInterface;
use Elastic\Apm\PhpAgent\Util\BaseObject;

class Metadata extends BaseObject
{
    /**
     * Service information
     *
     * @var Service
     */
    protected $service;

    /**
     * @var Process
     */
    protected $process;

    /**
     * @var System
     */
    protected $system;

    /**
     * Describes the authenticated User for a request.
     *
     * @var User
     */
    protected $user;

    /**
     * @var Tag
     */
    protected $labels;

    /**
     * @var array
     */
    protected $language = [];

    /**
     * @var array
     */
    protected $runtime = [];

    /** @var ConfigInterface */
    private $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        parent::__construct($config->getMetadata());
    }

    public function init()
    {
        if (null === $this->service) {
            $this->service = new Service([
                'agent' => new Agent([
                    'name' => Config::AGENT_NAME,
                    'version' => Config::AGENT_VERSION,
                ]),
                'framework' => $this->config->getFramework() ?? new Framework([]),
                'language' => new Language($this->language),
                'runtime' => new Runtime($this->runtime),
                'name' => $this->config->getAppName(),
                'environment' => 'unknown',
                'version' => $this->config->getAppVersion(),
            ]);
        }
        if (null === $this->system) {
            $this->system = new System();
        }
        if (null === $this->process) {
            $this->process = new Process();
        }
    }

    /**
     * @param Service $service
     */
    public function setService(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param Process $process
     */
    public function setProcess(Process $process)
    {
        $this->process = $process;
    }

    /**
     * @param System $system
     */
    public function setSystem(System $system)
    {
        $this->system = $system;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param Tag $labels
     */
    public function setLabels(Tag $labels)
    {
        $this->labels = $labels;
    }

    /**
     * @return Service
     */
    public function getService(): Service
    {
        return $this->service;
    }

    /**
     * @return Process
     */
    public function getProcess(): Process
    {
        return $this->process;
    }

    /**
     * @return System
     */
    public function getSystem(): System
    {
        return $this->system;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Tag
     */
    public function getLabels(): Tag
    {
        return $this->labels;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'service' => $this->service,
            'process' => $this->process,
            'system' => $this->system,
            'user' => $this->user,
            'labels' => $this->labels,
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
            'required' => ['service'],
        ];
    }
}
