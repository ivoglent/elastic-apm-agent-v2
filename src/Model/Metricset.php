<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/22/19
 * Time: 5:44 PM
 */

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;

class Metricset implements ModelInterface
{

    /**
     * Get object's json encoded information
     *
     * @return string
     */
    public function getJsonData(): string
    {
        // TODO: Implement getJsonData() method.
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }
}