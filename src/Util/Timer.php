<?php

namespace Elastic\Apm\PhpAgent\Util;

use Elastic\Apm\PhpAgent\Interfaces\TimerInterface;

class Timer implements TimerInterface
{
    /**
     * @var int
     */
    private $startTime;

    /**
     * @var int
     */
    private $stopTime;

    /**
     * Use the time in micro-second or milli-second
     * @var bool|null
     */
    private $us = false;

    public function __construct(?bool $us = true)
    {
        $this->us = $us;
    }

    /**
     * Start the timer
     *
     * @return mixed
     */
    public function start()
    {
        return $this->startTime = $this->now($this->us);
    }

    /**
     * Stop current timer
     *
     * @return mixed
     */
    public function stop()
    {
        return $this->stopTime = $this->now($this->us);
    }

    /**
     * Get spent time
     *
     * @return int
     */
    public function getElapsedTime(): int
    {
        if ($this->stopTime) {
            return $this->stopTime - $this->startTime;
        }

        return $this->now($this->us) - $this->startTime;
    }

    /**
     * Get current time
     *
     * @param bool|null $us
     *
     * @return int
     */
    public function now(?bool $us = true): int
    {
        if ($us) {
            return $this->microSeconds();
        }

        return $this->milliSeconds();
    }

    /**
     * @return int
     */
    private function milliSeconds(): int
    {
        $mt = explode(' ', microtime());

        return ((int) $mt[1]) * 1000 + ((int) round($mt[0] * 1000));
    }

    /**
     * @return int
     */
    private function microSeconds(): int
    {
        $mt = explode(' ', microtime());

        return ((int) $mt[1]) * 1000000 + ((int) round($mt[0] * 1000000));
    }
}
