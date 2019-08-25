<?php

namespace Elastic\Apm\PhpAgent;

use Elastic\Apm\PhpAgent\Exception\RuntimeException;
use Elastic\Apm\PhpAgent\Interfaces\AgentInterface;
use Elastic\Apm\PhpAgent\Interfaces\ConfigInterface;
use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;
use Elastic\Apm\PhpAgent\Model\Context\SpanContext;
use Elastic\Apm\PhpAgent\Model\Error;
use Elastic\Apm\PhpAgent\Model\Exception;
use Elastic\Apm\PhpAgent\Model\Metadata;
use Elastic\Apm\PhpAgent\Model\Metricset;
use Elastic\Apm\PhpAgent\Model\Span;
use Elastic\Apm\PhpAgent\Model\Transaction;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Agent implements AgentInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var DataCollector
     */
    private $dataCollector;

    /** @var ModelInterface */
    private $currentParent;

    /**
     * @var array
     */
    private $traces = [];

    /**
     * Agent constructor.
     * @param ConfigInterface $config
     * @throws RuntimeException
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    private function init() {
        $this->traces = [];
        $this->currentParent = null;
        $this->dataCollector = new DataCollector();
        $this->dataCollector->register(new Metadata($this->config));
    }

    /**
     * Start new transaction with provided name and type
     * for some cases, we need sync transaction ID with other system, let pass on startTransaction function
     *
     * @param string $name
     * @param string $type
     * @param string|null $id
     * @return mixed
     */
    public function startTransaction(string $name, string $type, ?string $id = null)
    {
        $transaction = new Transaction([
           'name' => $name,
           'type' => $type,
           'id' => $id,
        ]);
        $transaction->start();
        $this->dataCollector->setTransaction($transaction);
        $this->currentParent = $transaction;
    }

    /**
     * Stop current transaction
     * @throws RuntimeException
     * @throws GuzzleException
     */
    public function stopTransaction(?string $result = null): void
    {
        $this->dataCollector->getTransaction()->stop($result);
        $this->currentParent = null;
        $this->send();
    }

    /**
     * @return Transaction
     * @throws RuntimeException
     */
    public function getTransaction(): Transaction {
        return $this->dataCollector->getTransaction();
    }

    /**
     * Start trace with a transaction span
     *
     * @param string $name Name of trace span
     * @param string $type Type of trace span
     * @return Span
     * @throws RuntimeException
     */
    public function startTrace(string $name, string $type): Span
    {
        $span = new Span([
            'name' => $name,
            'type' => $type,
        ]);
        //Set transaction / trace
        $span->start();
        $span->setStart($this->dataCollector->getTransaction()->getElapsedTime());
        $this->traces[$span->getId()] = $span;
        $this->currentParent = $span;

        return  $span;
    }

    /**
     * Stop for current trace in the stack
     * Remind that, a span trace will be pushed to a trace stack and pop back for latest stopping
     *
     * @param string|null $id
     * @param SpanContext|null $context
     * @return mixed
     * @throws RuntimeException
     */
    public function stopTrace(?string $id = null, ?SpanContext $context = null)
    {
        /* @var Span $span */
        if (null === $id) {
            $span = array_pop($this->traces);
        } else {
            $span = $this->traces[$id];
            unset($this->traces[$id]);
        }

        $span->setContext($context->getSpanType(), $context);
        $span->stop();
        $this->currentParent = null;
        $this->register($span);
    }

    public function register(ModelInterface $model) {
        $this->dataCollector->register($model);
    }

    /**
     * Register metricset for current transaction
     *
     *
     * @param Metricset $metric
     * @return mixed
     */
    public function registerMetric(Metricset $metric)
    {
        // TODO: Implement registerMetric() method.
    }

    /**
     * Set config for APM agent
     *
     * @param ConfigInterface $config
     * @return mixed
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Return current config of APM Agent
     *
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    /**
     * @param \Throwable $throwable
     * @return mixed|void
     * @throws RuntimeException
     */
    public function notifyException(Throwable $throwable)
    {
        $exception = new Exception([
            'code' => $throwable->getCode(),
            'message' => $throwable->getMessage(),
            'type' => get_class($throwable),
        ]);
        $exception->setStacktrace($throwable->getTrace());
        $error = new Error([
            'parent_id' => null === $this->currentParent ? $this->dataCollector->getTransaction()->getId() : $this->currentParent->getId(),
            'transaction' => $this->dataCollector->getTransaction(),
            'exception' => $exception,
        ]);

        $this->dataCollector->register($error);
    }

    /**
     * Send all information to APM server
     *
     * @throws GuzzleException
     * @return bool
     */
    public function send(?RequestInterface $request = null): bool
    {
        $client = $this->config->getClient();
        if (null === $request) {
            $request = $this->makeRequest();
        }
        /** @var ResponseInterface $response */
        $response = $client->send($request);
        $this->init();
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }

    /**
     * @return RequestInterface
     */
    protected function makeRequest(): RequestInterface
    {
        $endpoint = sprintf('%s/intake/v2/events', $this->config->getServerUrl());
        $data = $this->dataCollector->getData();
        return new Request(
            'POST',
            $endpoint,
            $this->getRequestHeaders(),
            $data
        );
    }

    /**
     * @return array
     */
    private function getRequestHeaders()
    {
        $headers = [
            'Content-Type' => 'application/x-ndjson',
            'User-Agent' => sprintf('%s/%s', $this->config->getAgentConfig()->getName(), $this->config->getAgentConfig()->getVersion()),
        ];
        $secretToken = $this->config->getSecretToken();
        if (!empty($secretToken)) {
            $headers['Authorization'] = sprintf('Bearer %s', $secretToken);
        }

        return $headers;
    }
}
