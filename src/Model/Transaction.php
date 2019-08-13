<?php

namespace Elastic\Apm\PhpAgent\Model;

use Elastic\Apm\PhpAgent\Model\Context\Context;
use Elastic\Apm\PhpAgent\Model\Transaction\SpanCount;

class Transaction extends AbstractModel
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
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
    protected $sampled = true;

    public function __construct(?array $config = [])
    {
        parent::__construct($config);
        if (null === $this->id) {
            $this->id = $this->generateId(16);
        }

        if (null === $this->trace_id) {
            $this->trace_id = $this->generateId(16);
        }

        if (null === $this->span_count) {
            $this->span_count = new SpanCount(['started' => 0, 'dropped' => 0]);
        }
        $this->context = new Context();
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
     * @return Span
     */
    public function setSpan(Span &$span): Span
    {
        $span->setTransactionId($this->id);
        $span->setTraceId($this->trace_id);
        $span->setParentId($this->id);
        $this->span_count->increase();

        return $span;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @param bool $sampled
     */
    public function setSampled(bool $sampled)
    {
        $this->sampled = $sampled;
    }

    /**
     * @param string|null $result
     */
    public function stop(?string $result = null): void
    {
        parent::stop();
        if ($result) {
            $this->result = $result;
        }
    }

    /**
     * @param string $result
     */
    public function setResult(string $result): void
    {
        $this->result = $result;
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
            'sampled' => $this->sampled,
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
                'sampled' => 'boolean',
            ],
        ];
    }
}
