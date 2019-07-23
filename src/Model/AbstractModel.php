<?php
namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;
use Elastic\Apm\PhpAgent\Interfaces\TimedInterface;
use Elastic\Apm\PhpAgent\Interfaces\TimerInterface;
use Elastic\Apm\PhpAgent\Util\BaseObject;
use Elastic\Apm\PhpAgent\Util\Timer;

abstract class AbstractModel extends BaseObject implements ModelInterface, TimedInterface
{
    /** @var  TimerInterface */
    protected $timer;

    /**
     * Hex encoded 128 random bits ID of the trace
     *
     * @var  string
     */
    protected $id;

    /**
     * Hex encoded 64 random bits ID of the correlated transaction. Must be present if trace_id and parent_id are set.
     *
     * @var  string
     */
    protected $transaction_id;

    /**
     * Hex encoded 128 random bits ID of the correlated trace. Must be present if transaction_id and parent_id are set.
     *
     * @var string
     */
    protected $trace_id;

    /**
     * Hex encoded 64 random bits ID of the parent transaction or span. Must be present if trace_id and transaction_id are set.
     *
     * @var  string
     */
    protected $parent_id;

    /**
     * @var integer
     */
    protected $timestamp;

    public function __construct(?array $config = [])
    {
        parent::__construct($config);
        $this->timer = new Timer(false);
        $this->id = $this->generateId(16);
    }


    /**
     * Start trace
     */
    public function start(): void {
        $this->timer->start();
        $this->getTimestampStart();
    }

    /**
     * Stop current trace
     */
    public function stop(): void {
        $this->timer->stop();
    }

    /**
     * Get total spent time for this trace
     *
     * @return int
     */
    public function getElapsedTime(): int {
        return $this->timer->getElapsedTime();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transaction_id;
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId(string $transactionId)
    {
        $this->transaction_id = $transactionId;
    }

    /**
     * @return string
     */
    public function getTraceId(): string
    {
        return $this->trace_id;
    }

    /**
     * @param string $traceId
     */
    public function setTraceId(string $traceId)
    {
        $this->trace_id = $traceId;
    }

    /**
     * @return string
     */
    public function getParentId(): string
    {
        return $this->parent_id;
    }

    /**
     * @param string $parentId
     */
    public function setParentId(string $parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * Get start timestamp
     *
     * @return int
     */
    public function getTimestampStart(): int
    {
        return $this->timestamp = $this->timer->now(true);
    }
}