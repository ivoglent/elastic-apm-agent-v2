<?php

namespace Elastic\Apm\PhpAgent\Model\Virtualize;

use Elastic\Apm\PhpAgent\Util\BaseObject;

class Pod extends BaseObject
{
    /**
     * Kubernetes pod name
     *
     * @var string
     */
    protected $name;

    /**
     * Kubernetes pod uid
     *
     * @var string
     */
    protected $uid;

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $uid
     */
    public function setUid(string $uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'uid' => $this->uid,
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
            'required' => ['name', 'uid'],
            'maxLength' => [
                'name' => 1024,
                'uid' => 1024,
            ],
        ];
    }
}
