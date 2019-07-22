<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/22/19
 * Time: 5:43 PM
 */

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;
use Elastic\Apm\PhpAgent\Interfaces\TimedInterface;

class Transaction implements ModelInterface, TimedInterface
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

    public function start(): void
    {
        // TODO: Implement start() method.
    }

    public function stop(): void
    {
        // TODO: Implement stop() method.
    }

    public function getStartTime(): int
    {
        // TODO: Implement getStartTime() method.
    }

    public function getStopTime(): int
    {
        // TODO: Implement getStopTime() method.
    }

    public function getElapsedTime(): int
    {
        // TODO: Implement getElapsedTime() method.
    }
}