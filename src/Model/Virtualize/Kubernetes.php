<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/23/19
 * Time: 3:57 PM
 */

namespace Elastic\Apm\PhpAgent\Model\Virtualize;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Kubernetes extends BaseObject
{
    /**
     * Kubernetes namespace
     *
     * @var string
     */
    private $namespace;

    /**
     *
     * @var Pod
     */
    private $pod;

    /**
     * @var Node
     */
    private $node;

    /**
     * @param string $namespace
     */
    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @param Pod $pod
     */
    public function setPod(Pod $pod)
    {
        $this->pod = $pod;
    }

    /**
     * @param Node $node
     */
    public function setNode(Node $node)
    {
        $this->node = $node;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'namespace' => $this->namespace,
            'pod' => $this->pod,
            'node' => $this->node
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
            'required' => ['namespace'],
            'maxLength' => [
                'namespace' => 1024
            ]
        ];
    }
}