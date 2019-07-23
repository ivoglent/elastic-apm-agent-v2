<?php


namespace Elastic\Apm\PhpAgent\Tests;


use Elastic\Apm\PhpAgent\Agent;
use Elastic\Apm\PhpAgent\Config;
use PHPUnit\Framework\TestCase;

class AgentTest extends TestCase
{

    public function testTest() {
        $config = new Config('Test', '10.0', 'http://192.168.100.101:8200', 'apmtoken');
        /** @var \Elastic\Apm\PhpAgent\Agent $agent */
        $agent = new Agent($config);
        $agent->startTransaction('test', 'test');
        $agent->stopTransaction();
    }
}