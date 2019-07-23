<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/22/19
 * Time: 5:43 PM
 */

namespace Elastic\Apm\PhpAgent\Model;

use Elastic\Apm\PhpAgent\Model\Context\Context;
use Elastic\Apm\PhpAgent\Model\Transaction\SpanCount;
use Elastic\Apm\PhpAgent\Model\Transaction\TransactionName;
use Elastic\Apm\PhpAgent\Model\Transaction\TransactionType;

class Transaction extends AbstractModel
{
    /**
     * @var Span[]
     */
    protected $spans = [];

    /**
     * @var TransactionName
     */
    public $name;

    /**
     * @var TransactionType
     */
    public $type;

    /**
     * @var SpanCount
     */
    protected $span_count;

    /**
     * @var Context
     */
    protected $context;

    /**
     * How long the transaction took to complete, in ms with 3 decimal points
     *
     * @var float
     */
    public $duration;

    /**
     * The result of the transaction. For HTTP-related transactions, this should be the status code formatted like 'HTTP 2xx'
     *
     * @var string
     */
    protected $result;

    /**
     * A mark captures the timing of a significant event during the lifetime of a transaction. Marks are organized into groups and can be set by the user or the agent.
     *
     * @var object
     */
    protected $marks;

    /**
     * Transactions that are 'sampled' will include all available information. Transactions that are not sampled will not have 'spans' or 'context'. Defaults to true.
     *
     * @var bool
     */
    protected $sampled;

    public function __construct(?array $config = [])
    {
        $this->type = new TransactionType($config);
        $this->name = new TransactionName($config);
        if (!empty($config['id'])) {
            $this->id = $config['id'];
        } else {
            $this->id = $this->generateId(16);
        }

        if (!empty($config['trace_id'])) {
            $this->trace_id = $config['trace_id'];
        } else {
            $this->trace_id = $this->generateId(16);
        }
        if (null === $this->span_count) {
            $this->span_count = new SpanCount(['started' => 0, 'dropped' => 0]);
        }
        parent::__construct([]);
    }

    /**
     * @return SpanCount
     */
    public function getSpanCount(): SpanCount
    {
        return $this->span_count;
    }

    /**
     * @param SpanCount $span_count
     */
    public function setSpanCount(SpanCount $span_count): void
    {
        $this->span_count = $span_count;
    }

    /**
     * @param Span $span
     */
    public function setSpan(Span $span) {
        $span->setTransactionId($this->id);
        $span->setTraceId($this->trace_id);
        $span->setParentId($this->id);
        $this->spans[] = $span;
        $this->span_count->setStarted(count($this->spans));
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'timestamp' => $this->timestamp,
            'parent_id' => $this->parent_id,
            'trace_id' => $this->trace_id,
            'span_count' => $this->span_count,
            'context' => $this->context,
            'duration' => $this->duration,
            'result' => $this->result,
            'marks' => $this->marks,
            'sampled' => $this->sampled
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
            'required' => ['id', 'trace_id', 'span_count', 'duration', 'type', 'name'],
            'types' => [
                'duration' => 'float',
                'sampled' => 'boolean'
            ]
        ];
    }
}