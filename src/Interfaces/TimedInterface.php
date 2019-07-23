<?php
namespace Elastic\Apm\PhpAgent\Interfaces;


interface TimedInterface
{
    public function start(): void;
    public function stop(): void;
    public function getElapsedTime(): int;
    /**
     * Get start timestamp
     *
     * @return int
     */
    public function getTimestampStart():int ;

}