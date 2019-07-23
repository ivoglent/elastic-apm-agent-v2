<?php
namespace Elastic\Apm\PhpAgent;

use Elastic\Apm\PhpAgent\Exception\RuntimeException;
use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;
use Elastic\Apm\PhpAgent\Model\Span;
use Elastic\Apm\PhpAgent\Model\Transaction;

class DataCollector
{
    /**
     * @var ModelInterface[]
     */
    private $data = [];

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @return Transaction
     * @throws RuntimeException
     */
    public function getTransaction(): Transaction
    {
        if (null === $this->transaction) {
            throw new RuntimeException('No active transaction found!');
        }
        return $this->transaction;
    }

    /**
     * @param Transaction $transaction
     */
    public function setTransaction(Transaction $transaction): void
    {
        $this->transaction = $transaction;
    }


    /**
     * @param Span $model
     * @throws RuntimeException
     */
    public function register(Span $model) {
        if (null === $this->transaction) {
            throw new RuntimeException('No active transaction found!');
        }
        $this->transaction->setSpan($model);
    }

    /**
     * Reset data collector by remove all registed data and transactions
     */
    public function reset() {
        $this->transaction = null;
        $this->data = [];
    }

    /**
     * Get all stored information in ND-JSON format
     *
     * @return string
     */
    public function getData() {
        $data = array_merge($this->data, [$this->transaction]);
        return sprintf("%s\n", implode("\n", array_map(function($obj) {
            /** @var ModelInterface $obj */
            return $obj->getJsonData();
        }, $data)));
    }
}