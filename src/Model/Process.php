<?php

namespace Elastic\Apm\PhpAgent\Model;

use Elastic\Apm\PhpAgent\Util\BaseObject;

class Process extends BaseObject
{
    /**
     * Process ID of the service
     *
     * @var int
     */
    protected $pid;

    /**
     * Parent process ID of the service
     *
     * @var int
     */
    protected $ppid;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var array
     */
    protected $argv;

    public function init()
    {
        if (null === $this->pid) {
            $this->pid = getmypid();
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'pid' => $this->pid,
            'ppid' => $this->ppid,
            'title' => $this->title,
            'argv' => $this->argv,
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
            'required' => ['pid'],
        ];
    }
}
