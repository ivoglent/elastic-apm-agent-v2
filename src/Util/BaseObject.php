<?php
namespace Elastic\Apm\PhpAgent\Util;


use Elastic\Apm\PhpAgent\Exception\DataInvalidException;
use Elastic\Apm\PhpAgent\Exception\InvalidConfigException;
use Elastic\Apm\PhpAgent\Exception\RuntimeException;
use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;

abstract class BaseObject implements ModelInterface
{
    /**
     * Limitation of debug back trace
     *
     * @var int
     */
    public $limitTrace = 10;

    public function __construct(?array $config = [])
    {
        foreach ($config as $key => $value) {
            if (property_exists($this, $key) && $this->canSetProperty($key)) {
                $this->{$key} = $value;
            }
        }
        $this->init();
    }

    /**
     * Allow children object run something after create instance succeed
     */
    public function init() {
        //This is empty function!!!
    }

    /**
     * Returns the value of an object property.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `$value = $object->property;`.
     * @param string $name the property name
     * @return mixed the property value
     * @throws RuntimeException if the property is not defined
     * @throws RuntimeException if the property is write-only
     * @see __set()
     */
    public function __get($name)
    {
        $getter = $this->toCamel('get', $name);
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (method_exists($this,  $this->toCamel('set', $name))) {
            throw new RuntimeException('Getting write-only property: ' . get_class($this) . '::' . $name);
        }
        throw new RuntimeException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }
    /**
     * Sets value of an object property.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `$object->property = $value;`.
     * @param string $name the property name or the event name
     * @param mixed $value the property value
     * @throws RuntimeException if the property is not defined
     * @throws RuntimeException if the property is read-only
     * @see __get()
     */
    public function __set($name, $value)
    {
        $setter = $this->toCamel('set', $name);
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        }/* elseif (property_exists($this, $name)){
            $this->{$name} = $value;
        }*/ elseif (method_exists($this, 'get' . $name)) {
            throw new RuntimeException('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new RuntimeException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * @param $prefix
     * @param $name
     * @return string
     *
     * @author Long Nguyen <long.nguyen@zinio.com>
     */
    private function toCamel($prefix, $name) {
        $partNames = explode('_', $name);
        $method = $prefix;
        foreach ($partNames as &$partName) {
            $partName = ucfirst($partName);
        }
        return $method . implode('', $partNames);
    }

    /**
     * @param $prefix
     * @param $camel
     * @return mixed
     *
     * @author Long Nguyen <long.nguyen@zinio.com>
     */
    protected function camelToField($prefix, $camel) {
        $camel = preg_replace("/^$prefix/", '', $camel);
        $camel[0] = strtolower($camel[0]);
        for ($i = 0; $i < strlen($camel); $i++) {
            if (ctype_upper($camel[$i])) {
                $camel[$i] = strtolower($camel[$i]);
                $camel = substr($camel, 0, $i) . '_' . substr($camel, $i);
            }
        }
        //$camel = preg_replace('/[A-Z]/', '_${1}', $camel);
        return $camel;
    }

    /**
     * Checks if a property is set, i.e. defined and not null.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `isset($object->property)`.
     *
     * Note that if the property is not defined, false will be returned.
     * @param string $name the property name or the event name
     * @return bool whether the named property is set (not null).
     * @see http://php.net/manual/en/function.isset.php
     */
    public function __isset($name)
    {
        $getter = $this->toCamel('get', $name);
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        }
        return false;
    }

    /**
     * Sets an object property to null.
     *
     * Note that if the property is not defined, this method will do nothing.
     * If the property is read-only, it will throw an exception.
     * @param string $name the property name
     * @throws InvalidConfigException
     * @see http://php.net/manual/en/function.unset.php
     */
    public function __unset($name)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter(null);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new InvalidConfigException('Unsetting read-only property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * Calls the named method which is not a class method.
     *
     * @param string $name the method name
     * @param array $params method parameters
     * @throws RuntimeException when calling unknown method
     * @return mixed the method return value
     */
    public function __call($name, $params)
    {
        throw new RuntimeException('Calling unknown method: ' . get_class($this) . "::$name()");
    }

    /**
     * Returns a value indicating whether a property is defined.
     *
     * @param string $name the property name
     * @param bool $checkVars whether to treat member variables as properties
     * @return bool whether the property is defined
     * @see canGetProperty()
     * @see canSetProperty()
     */
    public function hasProperty($name, $checkVars = true)
    {
        return $this->canGetProperty($name, $checkVars) || $this->canSetProperty($name, false);
    }

    /**
     * Returns a value indicating whether a property can be read.
     *
     * @param string $name the property name
     * @param bool $checkVars whether to treat member variables as properties
     * @return bool whether the property can be read
     * @see canSetProperty()
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return method_exists($this, 'get' . $name) || method_exists($this, $this->toCamel('get', $name)) || ($checkVars && property_exists($this, $name));
    }

    /**
     * Returns a value indicating whether a property can be set.
     *
     * @param string $name the property name
     * @param bool $checkVars whether to treat member variables as properties
     * @return bool whether the property can be written
     * @see canGetProperty()
     */
    public function canSetProperty($name, $checkVars = true)
    {
        return method_exists($this, 'set' . $name) || method_exists($this, $this->toCamel('set', $name)) || ($checkVars && property_exists($this, $name));
    }
    /**
     * Returns a value indicating whether a method is defined
     *
     * @param string $name the method name
     * @return bool whether the method is defined
     */
    public function hasMethod($name)
    {
        return method_exists($this, $name);
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
        return \json_encode($data, JSON_FORCE_OBJECT);
    }

    /**
     * Make properties validation
     *
     * @return bool
     * @throws DataInvalidException
     */
    public function validate(): bool {
        $rules = $this->validationRules();
        if (!is_array($rules)) {
            $rules = [];
        }
        if (!isset($rules['required'])) {
            $rules['required'] = [];
        }

        if (!isset($rules['depends'])) {
            $rules['depends'] = [];
        }

        if (!isset($rules['maxLength'])) {
            $rules['maxLength'] = [];
        }

        if (!isset($rules['types'])) {
            $rules['types'] = [];
        }
        $rules['maxLength'] = array_merge([
            'maxLength' => [
                'id' => 1024,
                'trace_id' => 1024,
                'transaction_id' => 1024,
                'parent_id' => 1024
            ]
        ], $rules['maxLength']);
        foreach ($rules['required'] as $property) {
            if (!property_exists($this, $property) || $this->{$property} === null || $this->{$property} === '') {
                throw new DataInvalidException([$property], get_called_class(), 'Field(s) required is empty or not exists.');
            }
        }

        foreach ($rules['depends'] as $property => $depends) {
            if (!empty($this->{$property})) {
                foreach ($depends as $depend) {
                    if (!isset($this->{$depend}) || empty($this->{$depend})) {
                        throw new DataInvalidException([$depend], get_called_class(), "Field(s) required when {$property} was used.");
                    }
                }
            }
        }

        foreach ($rules['maxLength'] as $property => $length) {
            if ($this->canGetProperty($property) && strlen($this->{$property}) > $length) {
                throw new DataInvalidException([$property], get_called_class(),'Can not get or Max length reached at : ' . $length);
            }
        }

        foreach ($rules['types'] as $property => $type) {
            if (!empty($this->{$type}) && gettype($this->{$property}) !== $type) {
                throw new DataInvalidException([$property], get_called_class(),'Invalid data type : ' . $type);
            }
        }
        return true;
    }


    /**
     * @param int|null $length
     * @return bool|string
     */
    public function generateId(?int $length = 16): string {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    }

    /**
     * @return string
     * @throws DataInvalidException
     */
    public function __toString()
    {
        return $this->getJsonData();
    }

    /**
     * @return array
     * @throws DataInvalidException
     */
    public function jsonSerialize()
    {
        $data = [];
        if ($this->validate()) {
            $data = $this->toArray();
        }
        return $data;
    }

    /**
     * @return array
     *
     * @param string $endingFile
     */
    public function getStackTraces($endingFile = '') {
        $stacktrace = [];
        $traces = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, $this->limitTrace + 2);
        $traces = array_slice($traces, 2);
        foreach ($traces as $trace) {
            $item = [
                'function' => $trace['function'] ?? '(closure)'
            ];

            if (isset($trace['line']) === true) {
                $item['lineno'] = $trace['line'];
            }

            if (isset($trace['file']) === true) {
                $item['filename'] = basename($trace['file']);
                $item['abs_path'] = ($trace['file']);
            }

            if (isset($trace['class']) === true) {
                $item['module'] = $trace['class'];
            }


            if (!isset($item['lineno'])) {
                $item['lineno'] = 0;
            }

            if (!isset($item['filename'])) {
                $item['filename'] = '(anonymous)';
            }

            $stacktrace[] =  $item;
        }
        return $stacktrace;
    }
}