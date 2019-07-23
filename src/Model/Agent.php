<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/23/19
 * Time: 3:21 PM
 */

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Agent extends BaseObject
{
    /**
     * Name of the Elastic APM agent, e.g. "Python"
     *
     * @var string
     */
    private $name;

    /**
     * Version of the Elastic APM agent, e.g."1.0.0
     *
     * @var string
     */
    private $version;

    /**
     * Free format ID used for metrics correlation by some agents
     *
     * @var string
     */
    private $ephemeral_id;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @param string $ephemeral_id
     */
    public function setEphemeralId(string $ephemeral_id): void
    {
        $this->ephemeral_id = $ephemeral_id;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getEphemeralId(): string
    {
        return $this->ephemeral_id;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'version' => $this->version,
            'ephemeral_id' => $this->ephemeral_id
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
            'required' => ['name', 'version'],
            'maxLength' => [
                'name' => 1024,
                'version' => 1024,
                'ephemeral_id' => 1024
            ]
        ];
    }
}