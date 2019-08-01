<?php

namespace Elastic\Apm\PhpAgent\Model\Virtualize;

use Elastic\Apm\PhpAgent\Util\BaseObject;

class Kubernetes extends BaseObject
{
    /**
     * Kubernetes namespace
     *
     * @var string
     */
    protected $namespace;

    /**
     * @var Pod
     */
    protected $pod;

    /**
     * @var Node
     */
    protected $node;

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
            'node' => $this->node,
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
                'namespace' => 1024,
            ],
        ];
    }
}
