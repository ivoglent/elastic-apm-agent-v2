<?php
namespace Elastic\Apm\PhpAgent\Exception;


use Throwable;

class DataInvalidException extends \Exception
{
    private $fields = [];
    public function __construct($fields, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->fields = $fields;
        parent::__construct($message, $code, $previous);
    }
}