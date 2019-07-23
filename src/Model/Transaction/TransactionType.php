<?php
namespace Elastic\Apm\PhpAgent\Model\Transaction;


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
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


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