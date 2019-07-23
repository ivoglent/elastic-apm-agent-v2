<?php

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Model\Virtualize\Kubernetes;
use Elastic\Apm\PhpAgent\Util\BaseObject;

class System extends BaseObject
{
    /**
     * Architecture of the system the agent is running on.
     *
     * @var string
     */
    private $architecture;

    /**
     * Hostname of the system the agent is running on.
     *
     * @var string
     */
    private $hostname;

    /**
     * Name of the system platform the agent is running on.
     *
     * @var string
     */
    private $platform;

    /**
     * @var Kubernetes
     */
    private $kubernetes;

    /**
     * @param string $architecture
     */
    public function setArchitecture(string $architecture)
    {
        $this->architecture = $architecture;
    }

    /**
     * @param string $hostname
     */
    public function setHostname(string $hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * @param string $platform
     */
    public function setPlatform(string $platform)
    {
        $this->platform = $platform;
    }

    /**
     * @param Kubernetes $kubernetes
     */
    public function setKubernetes(Kubernetes $kubernetes)
    {
        $this->kubernetes = $kubernetes;
    }



    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'architecture' => $this->architecture,
            'hostname' => $this->hostname,
            'platform' => $this->platform,
            'kubernetes' => $this->kubernetes
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
            'maxLength' => [
                'architecture' => 1024,
                'hostname' => 1024,
                'platform' => 1024
            ]
        ];
    }
}