<?php
namespace Elastic\Apm\PhpAgent;

use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;

class DataCollector
{
    /**
     * @var ModelInterface[]
     */
    private $data = [];

    /**
     * @param ModelInterface $model
     */
    public function register(ModelInterface $model) {
        array_push($this->data, $model);
    }

    public function reset() {
        $this->data = [];
    }

    /**
     * Get all stored information in ND-JSON format
     *
     * @return string
     */
    public function getData() {
        return sprintf("%s\n", implode("\n", array_map(function($obj) {
            /** @var ModelInterface $obj */
            return $obj->getJsonData();
        }, $this->data)));
    }
}