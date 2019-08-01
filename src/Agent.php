<?php
namespace Elastic\Apm\PhpAgent;

use Elastic\Apm\PhpAgent\Interfaces\AgentInterface;
use Elastic\Apm\PhpAgent\Interfaces\ConfigInterface;
use Elastic\Apm\PhpAgent\Model\Context\SpanContext;
use Elastic\Apm\PhpAgent\Model\Metadata;
use Elastic\Apm\PhpAgent\Model\Metricset;
use Elastic\Apm\PhpAgent\Model\Span;
use Elastic\Apm\PhpAgent\Model\Transaction;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SebastianBergmann\Timer\RuntimeException;

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

    /**
     * @var array
     */
    private $traces = [];

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->dataCollector = new DataCollector();
        $this->dataCollector->register(new Metadata($config));
    }

    /**
     * Start new transaction with provided name and type
     * for some cases, we need sync transaction ID with other system, let pass on startTransaction function
     *
     * @param string $name
     * @param string $type
     * @param null|string $id
     * @return mixed
     */
    public function startTransaction(string $name, string $type, ?string $id = null)
    {
        $transaction = new Transaction([
           'name' => $name,
           'type' => $type,
           'id' => $id
        ]);
        $transaction->start();
        $this->dataCollector->setTransaction($transaction);
    }

    /**
     * Stop current transaction
     * @throws RuntimeException if transaction did not started yet.
     * @throws Exception\RuntimeException
     */
    public function stopTransaction(): void
    {
        $this->dataCollector->getTransaction()->stop();
        $this->send();
    }

    /**
     * Start trace with a transaction span
     *
     * @param string $name Name of trace span
     * @param string $type Type of trace span
     * @return Span
     * @throws Exception\RuntimeException
     */
    public function startTrace(string $name, string $type): Span
    {
        $span = new Span([
            'name' => $name,
            'type' => $type
        ]);
        //Set transaction / trace
        $span->start();
        $span->setStart($this->dataCollector->getTransaction()->getElapsedTime());
        $this->traces[$span->getId()] = $span;
        return  $span;
    }

    /**
     * Stop for current trace in the stack
     * Remind that, a span trace will be pushed to a trace stack and pop back for latest stopping
     *
     * @param null|string $id
     * @param SpanContext|null $context
     * @return mixed
     */
    public function stopTrace(?string $id = null, ?SpanContext $context = null)
    {
        /** @var Span $span */
        if (null === $id) {
            $span = array_pop($this->traces);
        } else {
            $span = $this->traces[$id];
            unset($this->traces[$id]);
        }

        $span->setContext($context);
        $span->stop();
        $this->dataCollector->register($span);
    }

    /**
     * Register metricset for current transaction
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
     * Send all information to APM server
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(): bool
    {
        $client = $this->config->getClient();
        $request = $this->makeRequest();//print_r($request->getBody()->getContents());exit;
        /** @var ResponseInterface $response */
        $response = $client->send($request);
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }

    /**
     * @return RequestInterface
     */
    private function makeRequest(): RequestInterface {
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
    private function getRequestHeaders() {
        $headers = [
            'Content-Type' => 'application/x-ndjson',
            'User-Agent'   => sprintf('%s/%s', $this->config->getAgentConfig()->getName(), $this->config->getAgentConfig()->getVersion()),
        ];
        $secretToken = $this->config->getSecretToken();
        if (!empty($secretToken)) {
            $headers['Authorization'] = sprintf('Bearer %s', $secretToken);
        }
        return $headers;
    }
}