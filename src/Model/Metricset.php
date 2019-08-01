<?php

namespace Elastic\Apm\PhpAgent\Model;

use Elastic\Apm\PhpAgent\Model\Type\SpanSubType;
use Elastic\Apm\PhpAgent\Model\Type\SpanType;

class Metricset extends AbstractModel
{
    /**
     * @var SpanType
     */
    protected $span_type;

    /**
     * @var SpanSubType
     */
    protected $span_subtype;

    /**
     * @var string
     */
    protected $transaction_name;

    /**
     * @var string
     */
    protected $transaction_type;

    /**
     * @var object
     */
    protected $samples;

    /**
     * @var Tag
     */
    protected $tags;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'timestamp' => $this->timestamp,
            'span_type' => $this->span_type,
            'span_subtype' => $this->span_subtype,
            'transaction_type' => $this->transaction_type,
            'transaction_name' => $this->transaction_name,
            'samples' => $this->samples,
            'tags' => $this->tags,
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
            'required' => ['samples', 'timestamp'],
        ];
    }
}
