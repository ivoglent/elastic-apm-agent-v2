<?php
namespace Elastic\Apm\PhpAgent\Util;


use Elastic\Apm\PhpAgent\Exception\DataInvalidException;
use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;

abstract class BaseObject implements ModelInterface
{
    public function __construct(?array $config = [])
    {
        foreach ($config as $key => $value) {
            if (isset($this->{$key})) {
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
     * @return string
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
            if (!isset($this->{$property}) || empty($this->{$property})) {
                throw new DataInvalidException([$property], 'Field(s) required is empty or not exists');
            }
        }

        foreach ($rules['depends'] as $property => $depends) {
            if (!empty($this->{$property})) {
                foreach ($depends as $depend) {
                    if (!isset($this->{$depend}) || empty($this->{$depend})) {
                        throw new DataInvalidException([$depend], "Field(s) required when {$property} was used.");
                    }
                }
            }
        }

        foreach ($rules['maxLength'] as $property => $length) {
            if (strlen($this->{$property}) > $length) {
                throw new DataInvalidException([$property], 'Max length reached at : ' . $length);
            }
        }

        foreach ($rules['types'] as $property => $type) {
            if (!empty($this->{$type}) && gettype($this->{$property}) !== $type) {
                throw new DataInvalidException([$property], 'Invalid data type : ' . $type);
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
     */
    public function __toString()
    {
        return $this->getJsonData();
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [];
        if ($this->validate()) {
            $data = $this->toArray();
        }
        return $data;
    }
}