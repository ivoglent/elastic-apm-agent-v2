<?php
namespace Elastic\Apm\PhpAgent;


use Elastic\Apm\PhpAgent\Interfaces\ConfigInterface;
use Elastic\Apm\PhpAgent\Model\Agent as AgentConfig;
use Elastic\Apm\PhpAgent\Model\Framework;
use Elastic\Apm\PhpAgent\Model\User;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class Config implements ConfigInterface
{
    const AGENT_NAME = 'APM PHP Agent';
    const AGENT_VERSION = '1.0.0';
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $secret_token;

    /**
     * @var Agent
     */
    private $agent;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $server_url;

    /**
     * @var Framework
     */
    private $framework;

    /**
     * @var User
     */
    private $user;

    /**
     * Config constructor.
     * @param string $name
     * @param string $version
     * @param string $secret_token
     * @param ClientInterface $client
     * @param string $server_url
     * @param Framework $framework
     * @param User $user
     */
    public function __construct( string $name, string $version, string $server_url, ?string $secret_token = null, ?Framework $framework = null, ?User $user = null, ?ClientInterface $client = null)
    {
        $this->name = $name;
        $this->version = $version;
        if (null !== $secret_token) {
            $this->secret_token = $secret_token;
        }
        if (null !== $client) {
            $this->client = $client;
        } else {
            $this->client = new Client();
        }
        if (null !== $server_url) {
            $this->server_url = $server_url;
        }
        if (null !== $framework) {
            $this->framework = $framework;
        }

        if (null !== $user) {
            $this->user = $user;
        }

        $this->agent = new AgentConfig([
            'name' => self::AGENT_NAME,
            'version' => self::AGENT_VERSION
        ]);
    }


    /**
     * Get application name
     *
     * @return string
     */
    public function getAppName(): string
    {
        return $this->name;
    }

    /**
     * Get application current version
     *
     * @return string
     */
    public function getAppVersion(): string
    {
        return $this->version;
    }

    /**
     * Get access token to connect to the server
     *
     * @return string
     */
    public function getSecretToken(): string
    {
        return $this->secret_token;
    }

    /**
     * Get base url of APM server
     *
     * @return string
     */
    public function getServerUrl(): string
    {
        return $this->server_url;
    }

    /**
     * Get client which will send the request to APM server
     *
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * Get framework information
     *
     * @return Framework
     */
    public function getFramework(): Framework
    {
        return $this->framework;
    }

    /**
     * Set using framework to config
     *
     * @param Framework $framework
     * @return mixed
     */
    public function setFramework(Framework $framework)
    {
        $this->framework = $framework;
    }

    /**
     * Get authenticated user
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Set authenticated user to config
     *
     * @param User $user
     * @return mixed
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return AgentConfig
     */
    public function getAgentConfig(): AgentConfig
    {
        return $this->agent;
    }
}