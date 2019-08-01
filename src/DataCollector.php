<?php
namespace Elastic\Apm\PhpAgent;

use Elastic\Apm\PhpAgent\Exception\RuntimeException;
use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;
use Elastic\Apm\PhpAgent\Model\Error;
use Elastic\Apm\PhpAgent\Model\Metadata;
use Elastic\Apm\PhpAgent\Model\Metricset;
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
     * @param ModelInterface $model
     * @throws RuntimeException
     */
    public function register(ModelInterface $model) {
        if ($model instanceof Span) {
            if (null === $this->transaction) {
                throw new RuntimeException('No active transaction found!');
            }
            $model = $this->transaction->setSpan($model);
        }

        $this->data[] = $model;

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
            $itemData =  $obj->getJsonData();
            $itemClass = get_class($obj);
            switch ($itemClass) {
                case Span::class:
                    $itemData =  sprintf('{"span" : %s}', $itemData);
                break;
                case Transaction::class:
                    $itemData =  sprintf('{"transaction" : %s}', $itemData);
                break;
                case Metricset::class:
                    $itemData =  sprintf('{"metric" : %s}', $itemData);
                break;
                case Metadata::class:
                    $itemData =  sprintf('{"metadata" : %s}', $itemData);
                break;
                case Error::class:
                    $itemData =  sprintf('{"error" : %s}', $itemData);
                break;
            }
            return $itemData;
        }, $data)));
    }
}