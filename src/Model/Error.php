<?php
namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;
use Elastic\Apm\PhpAgent\Model\Context\BaseContext;
use Elastic\Apm\PhpAgent\Model\Context\Context;

class Error extends AbstractModel implements ModelInterface
{
    /**
     * Data for correlating errors with transactions
     *
     * @var  Transaction
     */
    private $transaction;

    /** @var  Context */
    private $context;

    /** @var  string */
    private $culprit;

    /** @var  Exception */
    private $exception;

    /** @var  Log */
    private $log;

    /**
     * @param Transaction $transaction
     */
    public function setTransaction(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @param Context $context
     */
    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @param string $culprit
     */
    public function setCulprit(string $culprit)
    {
        $this->culprit = $culprit;
    }

    /**
     * @param Exception $exception
     */
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @param Log $log
     */
    public function setLog(Log $log)
    {
        $this->log = $log;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'trace_id' => $this->trace_id,
            'transaction_id' => $this->transaction_id,
            'transaction' => $this->transaction,
            'context' => $this->context,
            'culprit' => $this->culprit,
            'exception' => $this->exception,
            'log' => $this->log
        ];
    }

    /**
     * Get start timestamp
     *
     * @return int
     */
    public function getTimestampStart(): int
    {
        return $this->timer->now();
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
            'depends' => [
                'transaction_id' => ['trace_id', 'parent_id'],
                'trace_id' => ['parent_id'],
                'parent_id' => ['trace_id']
            ]
        ];
    }
}