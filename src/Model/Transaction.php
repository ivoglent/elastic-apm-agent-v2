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
use Elastic\Apm\PhpAgent\Model\Type\TransactionName;
use Elastic\Apm\PhpAgent\Model\Type\TransactionType;

class Transaction extends AbstractModel
{
    /**
     * @var TransactionName
     */
    private $name;

    /**
     * @var TransactionType
     */
    private $type;

    /**
     * @var SpanCount
     */
    private $span_count;

    /**
     * @var Context
     */
    private $context;

    /**
     * How long the transaction took to complete, in ms with 3 decimal points
     *
     * @var float
     */
    private $duration;

    /**
     * The result of the transaction. For HTTP-related transactions, this should be the status code formatted like 'HTTP 2xx'
     *
     * @var string
     */
    private $result;

    /**
     * A mark captures the timing of a significant event during the lifetime of a transaction. Marks are organized into groups and can be set by the user or the agent.
     *
     * @var object
     */
    private $marks;

    /**
     * Transactions that are 'sampled' will include all available information. Transactions that are not sampled will not have 'spans' or 'context'. Defaults to true.
     *
     * @var bool
     */
    private $sampled;

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
                'sampled' => 'boolean',
                'span_count' => 'integer'
            ]
        ];
    }
}