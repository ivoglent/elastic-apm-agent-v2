<?php
namespace Elastic\Apm\PhpAgent\Model\Type;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class SpanSubType extends BaseObject
{
    /**
     * A further sub-division of the type (e.g. postgresql, elasticsearch)
     *
     * @var string
     */
    protected $subtype;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'subtype' => $this->subtype
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
            'required' => ['subtype'],
            'maxLength' => [
                'subtype' => 1024
            ]
        ];
    }
}