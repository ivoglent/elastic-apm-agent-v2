<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/22/19
 * Time: 6:15 PM
 */

namespace Elastic\Apm\PhpAgent\Interfaces;


interface TimedInterface
{
    public function start(): void;
    public function stop(): void;
    public function getElapsedTime(): int;

}