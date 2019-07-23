<?php

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Model\Context\SpanContext;

class Span extends AbstractModel
{
    /**
     * Duration of the span in milliseconds
     *
     * @var int
     */
    private $duration;

    /**
     * Generic designation of a span in the scope of a transaction
     *
     * @var string
     */
    private $name;

    /**
     * List of stack frames with variable attributes (eg: lineno, filename, etc)
     *
     * @ref "../stacktrace_frame.json"
     *
     * @var Stacktrace[] | null
     */
    private $stacktrace;

    /**
     * Keyword of specific relevance in the service's domain (eg: 'db.postgresql.query', 'template.erb', etc)
     *
     * @var string
     */
    private $type;


    /**
     * Indicates whether the span was executed synchronously or asynchronously.
     *
     * @var bool
     */
    private $sync = false;

    /**
     * Offset relative to the transaction's timestamp identifying the start of the span, in milliseconds
     *
     * @var int
     */
    private $start;

    /**
     * A further sub-division of the type (e.g. postgresql, elasticsearch)
     *
     * @var string
     */
    private $subtype;

    /**
     * Span Contexts
     *
     * @var SpanContext[]
     */
    private $contexts = [];

    /**
     * The specific kind of event within the sub-type represented by the span (e.g. query, connect)
     *
     * @var string
     */
    private $action = null;




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
            'context' => $this->contexts,
            'duration' => $this->duration,
            'name' => $this->name,
            'stacktrace' => $this->stacktrace,
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
}