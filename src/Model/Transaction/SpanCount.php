<?php


namespace Elastic\Apm\PhpAgent\Model\Transaction;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class SpanCount extends BaseObject
{
    /**
     * Number of correlated spans that are recorded.
     *
     * @var integer
     */
    private $started;

    /**
     * Number of spans that have been dropped by the agent recording the transaction.
     *
     * @var integer
     */
    private $dropped;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'started' => $this->started,
            'dropped' => $this->dropped
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
            'required' => ['started'],
            'types' => [
                'started' => 'integer',
                'dropped' => 'integer'
            ]
        ];
    }
}