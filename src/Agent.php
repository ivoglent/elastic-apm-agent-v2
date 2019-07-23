<?php
namespace Elastic\Apm\PhpAgent;


use Elastic\Apm\PhpAgent\Interfaces\AgentInterface;
use Elastic\Apm\PhpAgent\Interfaces\ConfigInterface;
use Elastic\Apm\PhpAgent\Model\Metricset;
use Elastic\Apm\PhpAgent\Model\Span;
use GuzzleHttp\Client;
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

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->dataCollector = new DataCollector();
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

    }

    /**
     * Stop current transaction
     * @throws RuntimeException if transaction did not started yet.
     */
    public function stopTransaction(): void
    {
        // TODO: Implement stopTransaction() method.
    }

    /**
     * Start trace with a transaction span
     *
     * @param string $name Name of trace span
     * @param string $type Type of trace span
     * @return Span
     */
    public function startTrace(string $name, string $type): Span
    {
        // TODO: Implement startTrace() method.
    }

    /**
     * Stop for current trace in the stack
     * Remind that, a span trace will be pushed to a trace stack and pop back for latest stopping
     *
     * @return mixed
     */
    public function stopTrace()
    {
        // TODO: Implement stopTrace() method.
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
     */
    public function send(): bool
    {
        $client = $this->config->getClient();
        if (empty($client)) {
            $client = new Client();
        }
        try {
            $request = $this->makeRequest();
            /** @var ResponseInterface $response */
            $response = $client->send($request);
            return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
        } catch (\Exception $e) {
            //Silent
        }
        return false;
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