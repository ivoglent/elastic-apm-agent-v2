<?php

namespace Elastic\Apm\PhpAgent\Model\Virtualize;

use Elastic\Apm\PhpAgent\Util\BaseObject;

class Container extends BaseObject
{
    /**
     * Container ID
     *
     * @var string
     */
    protected $id;

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
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
            'required' => ['id'],
            'maxLength' => [
                'id' => 1024,
            ],
        ];
    }
}
