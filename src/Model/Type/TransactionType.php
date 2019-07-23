<?php
namespace Elastic\Apm\PhpAgent\Model\Type;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class TransactionType extends BaseObject
{
    /**
     * Keyword of specific relevance in the service's domain (eg: 'request', 'backgroundjob', etc)
     *
     * @var string
     */
    private $type;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type
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
            'required' => ['type'],
            'maxLength' => [
                'type' => 1024
            ]
        ];
    }
}