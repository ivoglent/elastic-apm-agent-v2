<?php

namespace Elastic\Apm\PhpAgent\Model\Transaction;

use Elastic\Apm\PhpAgent\Util\BaseObject;

class SpanCount extends BaseObject
{
    /**
     * Number of correlated spans that are recorded.
     *
     * @var int
     */
    protected $started;

    /**
     * Number of spans that have been dropped by the agent recording the transaction.
     *
     * @var int
     */
    protected $dropped;

    public function increase()
    {
        ++$this->started;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'started' => $this->started,
            'dropped' => $this->dropped,
        ];
    }

    /**
     * @return int
     */
    public function getStarted(): int
    {
        return $this->started;
    }

    /**
     * @param int $started
     */
    public function setStarted(int $started): void
    {
        $this->started = $started;
    }

    /**
     * @return int
     */
    public function getDropped(): int
    {
        return $this->dropped;
    }

    /**
     * @param int $dropped
     */
    public function setDropped(int $dropped): void
    {
        $this->dropped = $dropped;
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
                'dropped' => 'integer',
            ],
        ];
    }
}
