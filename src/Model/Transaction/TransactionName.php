<?php
namespace Elastic\Apm\PhpAgent\Model\Transaction;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class TransactionName extends BaseObject
{
    /**
     * Generic designation of a transaction in the scope of a single service (eg: 'GET /users/:id')
     *
     * @var string
     */
    public $name;

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