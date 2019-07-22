<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/22/19
 * Time: 6:16 PM
 */

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Interfaces\TimerInterface;
use Elastic\Apm\PhpAgent\Util\Timer;

abstract class AbstractModel
{
    /** @var  TimerInterface */
    protected $timer;
    public function __construct()
    {
        $this->timer = new Timer(false);
    }

    public function start() {
        $this->timer->start();
    }

    public function stop() {
        $this->timer->stop();
    }

    /**
     * @return int
     */
    public function getElapsedTime() {
        return $this->timer->getElapsedTime();
    }

}