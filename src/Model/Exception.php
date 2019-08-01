<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/23/19
 * Time: 2:36 PM
 */

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class Exception extends BaseObject
{
    /** @var  string */
    protected $code;

    /** @var   */
    protected $message;

    /** @var  string */
    protected $module;

    /** @var  object */
    protected $attributes;

    /** @var Stacktrace[] */
    protected $stacktrace = [];

    /** @var   */
    protected $type;

    /** @var  bool */
    protected $handled;
    

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param string $module
     */
    public function setModule(string $module)
    {
        $this->module = $module;
    }

    /**
     * @param object $attributes
     */
    public function setAttributes(object $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param Stacktrace[] $stacktrace
     */
    public function setStacktrace(array $stacktrace)
    {
        $this->stacktrace = $stacktrace;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param bool $handled
     */
    public function setHandled(bool $handled)
    {
        $this->handled = $handled;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'module' => $this->module,
            'attributes' => $this->attributes,
            'stacktrace' => $this->stacktrace,
            'type' => $this->type,
            'handled' => $this->handled
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
            'required' => ['message', 'type']
        ];
    }
}