<?php

namespace Elastic\Apm\PhpAgent\Interfaces;

use Elastic\Apm\PhpAgent\Model\Context\SpanContext;
use Elastic\Apm\PhpAgent\Model\Metricset;
use Elastic\Apm\PhpAgent\Model\Span;
use Elastic\Apm\PhpAgent\Model\Transaction;
use Psr\Http\Message\RequestInterface;
use SebastianBergmann\Timer\RuntimeException;

interface AgentInterface
{
    /**
     * Start new transaction with provided name and type
     * for some cases, we need sync transaction ID with other system, let pass on startTransaction function
     *
     * @param string $name
     * @param string $type
     * @param string|null $id
     * @return mixed
     */
    public function startTransaction(string $name, string $type, ?string $id = null);

    /**
     * Stop current transaction
     * @throws RuntimeException if transaction did not started yet.
     */
    public function stopTransaction(): void;

    /**
     * @return Transaction
     */
    public function getTransaction(): Transaction;

    /**
     * Start trace with a transaction span
     *
     * @param string $name Name of trace span
     * @param string $type Type of trace span
     * @return Span
     */
    public function startTrace(string $name, string $type): Span;

    /**
     * Stop for current trace in the stack
     * Remind that, a span trace will be pushed to a trace stack and pop back for latest stopping
     *
     * @param string|null $id
     * @param SpanContext|null $context
     * @return mixed
     */
    public function stopTrace(?string $id = null, ?SpanContext $context = null);

    /**
     * Register metricset for current transaction
     *
     * @param Metricset $metric
     * @return mixed
     */
    public function registerMetric(Metricset $metric);

    /**
     * Set config for APM agent
     *
     * @param ConfigInterface $config
     * @return mixed
     */
    public function setConfig(ConfigInterface $config);

    /**
     * Return current config of APM Agent
     *
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface;

    /**
     * @param \Throwable $throwable
     * @return mixed
     */
    public function notifyException(\Throwable $throwable);

    /**
     * Send all information to APM server
     *
     * @return bool
     */
    public function send(?RequestInterface $request = null): bool;
}
