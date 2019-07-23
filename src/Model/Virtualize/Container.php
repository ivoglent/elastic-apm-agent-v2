<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/23/19
 * Time: 3:53 PM
 */

namespace Elastic\Apm\PhpAgent\Model\Virtualize;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Container extends BaseObject
{
    /**
     * Container ID
     *
     * @var string
     */
    private $id;

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
            'id' => $this->id
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
                'id' => 1024
            ]
        ];
    }
}