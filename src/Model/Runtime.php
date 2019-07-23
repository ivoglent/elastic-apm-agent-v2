<?php
namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Runtime extends BaseObject
{
    /**
     *
     * @var string
     */
    private $name;

    /** @var   */
    private $version;
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'version' => $this->version
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
                'name' => 1024,
                'version' => 1024
            ]
        ];
    }
}