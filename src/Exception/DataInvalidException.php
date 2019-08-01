<?php
namespace Elastic\Apm\PhpAgent\Exception;


use Throwable;

class DataInvalidException extends \Exception
{
    private $fields = [];
    public function __construct($fields, $className, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->fields = $fields;
        parent::__construct($message . ' : ' . implode(', ', $fields) . ' in class ' . $className , $code, $previous);
    }
}