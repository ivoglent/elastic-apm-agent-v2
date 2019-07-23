<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/22/19
 * Time: 5:44 PM
 */

namespace Elastic\Apm\PhpAgent\Model;

use Elastic\Apm\PhpAgent\Model\Type\SpanSubType;
use Elastic\Apm\PhpAgent\Model\Type\SpanType;
use Elastic\Apm\PhpAgent\Model\Type\TransactionName;
use Elastic\Apm\PhpAgent\Model\Type\TransactionType;

class Metricset extends AbstractModel
{
    /**
     * @var SpanType
     */
    private $span_type;

    /**
     * @var SpanSubType
     */
    private $span_subtype;

    /**
     * @var TransactionName
     */
    private $transaction_name;

    /**
     * @var TransactionType
     */
    private $transaction_type;

    /**
     * @var object
     */
    private $samples;

    /**
     * @var Tag
     */
    private $tags;


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
            'tags' => $this->tags
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
            'required' => ['samples', 'timestamp']
        ];
    }

}