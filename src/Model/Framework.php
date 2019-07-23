<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/23/19
 * Time: 3:23 PM
 */

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Framework extends BaseObject
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