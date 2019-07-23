<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/23/19
 * Time: 3:31 PM
 */

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Process extends BaseObject
{
    /**
     * Process ID of the service
     *
     * @var int
     */
    private $pid;

    /**
     * Parent process ID of the service
     *
     * @var int
     */
    private $ppid;

    /**
     * @var string
     */
    private $title;

    /**
     * @var array
     */
    private $argv = [];

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'pid' => $this->pid,
            'ppid' => $this->ppid,
            'title' => $this->title,
            'argv' => $this->argv
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
            'required' => ['pid']
        ];
    }
}