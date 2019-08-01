<?php

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Exception\DataInvalidException;
use Elastic\Apm\PhpAgent\Model\Context\SpanContext;

class Span extends AbstractModel
{

    /**
     * Generic designation of a span in the scope of a transaction
     *
     * @var string
     */
    protected $name;

    /**
     * List of stack frames with variable attributes (eg: lineno, filename, etc)
     *
     * @ref "../stacktrace_frame.json"
     *
     * @var Stacktrace[] | null
     */
    protected $stacktrace;

    /**
     * Keyword of specific relevance in the service's domain (eg: 'db.postgresql.query', 'template.erb', etc)
     *
     * @var string
     */
    protected $type;


    /**
     * Indicates whether the span was executed synchronously or asynchronously.
     *
     * @var bool
     */
    protected $sync = false;

    /**
     * Offset relative to the transaction's timestamp identifying the start of the span, in milliseconds
     *
     * @var int
     */
    protected $start;

    /**
     * A further sub-division of the type (e.g. postgresql, elasticsearch)
     *
     * @var string
     */
    protected $subtype;

    /**
     * Span Contexts
     *
     * @var SpanContext
     */
    protected $context;

    /**
     * The specific kind of event within the sub-type represented by the span (e.g. query, connect)
     *
     * @var string
     */
    protected $action = null;

    /**
     * @param SpanContext $context
     */
    public function setContext(SpanContext $context) {
        $this->context = $context;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $stacktrace
     */
    public function setStacktrace($stacktrace)
    {
        $this->stacktrace = $stacktrace;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @param bool $sync
     */
    public function setSync(bool $sync)
    {
        $this->sync = $sync;
    }

    /**
     * @param int $start
     */
    public function setStart(int $start)
    {
        $this->start = $start;
    }

    /**
     * @param string $subtype
     */
    public function setSubtype(string $subtype)
    {
        $this->subtype = $subtype;
    }

    /**
     * @param SpanContext[] $contexts
     */
    public function setContexts(array $contexts)
    {
        $this->contexts = $contexts;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action)
    {
        $this->action = $action;
    }

    public function stop(): void
    {
        parent::stop();
        $traces = $this->getStackTraces(__FILE__);
        foreach ($traces as $trace) {
            $stacktrace = new Stacktrace($trace);
            $this->stacktrace[] = $stacktrace;
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'subtype' => $this->subtype,
            'transaction_id' => $this->transaction_id,
            'trace_id' => $this->trace_id,
            'parent_id' => $this->parent_id,
            'start' => $this->start,
            'action' => $this->action,
            'context' => $this->context,
            'duration' => $this->duration,
            'name' => $this->name,
            'stacktrace' => $this->stacktrace,
            'timestamp' => $this->timestamp,
            'sync' => $this->sync
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
            'required' => ['id', 'name', 'type', 'duration', 'trace_id', 'parent_id'],
            'maxLength' => [
                'name' => 1024,
                'action' => 1024
            ]
        ];
    }

    /**
     * @return string
     * @throws DataInvalidException
     */
    public function getJsonData(): string
    {
        $data = [];
        if ($this->validate()) {
            $data = $this->toArray();
        }
        return \json_encode($data);
    }
}