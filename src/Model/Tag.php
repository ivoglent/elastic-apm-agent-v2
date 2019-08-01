<?php


namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Tag extends BaseObject
{
    /** @var array  */
    protected $properties = [];

    public function __construct($config = [])
    {
        foreach ($config as $property => $value) {
            $this->properties[$property] = $value;
        }
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function set($name, $value) {
        $this->properties[$name] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->properties;
    }

    /**
     * Define object validation rules
     *
     * @return array
     */
    public function validationRules(): array
    {
        return [];
    }
}