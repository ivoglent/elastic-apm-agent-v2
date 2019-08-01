<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/23/19
 * Time: 3:59 PM
 */

namespace Elastic\Apm\PhpAgent\Model\Virtualize;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Node extends BaseObject
{
    /**
     * Kubernetes node name
     *
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name
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
            'required' => ['name'],
            'maxLength' => [
                'name' => 1024
            ]
        ];
    }
}