<?php

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Metadata extends BaseObject
{
    /**
     * Service information
     *
     * @var Service
     */
    private $service;

    /**
     *
     * @var Process
     */
    private $process;

    /**
     *
     * @var System
     */
    private $system;

    /**
     * Describes the authenticated User for a request.
     *
     * @var User
     */
    private $user;

    /**
     * @var Tag
     */
    private $labels;

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
     * @return array
     */
    public function toArray(): array
    {
        return [
            'service' => $this->service,
            'process' => $this->process,
            'system' => $this->system,
            'user' => $this->user,
            'labels' => $this->labels
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
            'required' => ['service']
        ];
    }
}