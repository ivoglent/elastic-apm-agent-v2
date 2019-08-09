<?php

namespace Elastic\Apm\PhpAgent\Interfaces;

use Elastic\Apm\PhpAgent\Model\Agent as AgentConfig;
use Elastic\Apm\PhpAgent\Model\Framework;
use Elastic\Apm\PhpAgent\Model\User;
use GuzzleHttp\ClientInterface;

interface ConfigInterface
{
    /**
     * Get application name
     *
     * @return string
     */
    public function getAppName(): string;

    /**
     * Get application current version
     *
     * @return string
     */
    public function getAppVersion(): string;

    /**
     * Get access token to connect to the server
     *
     * @return string|null
     */
    public function getSecretToken(): ?string;

    /**
     * Get base url of APM server
     *
     * @return string
     */
    public function getServerUrl(): string;

    /**
     * Get client which will send the request to APM server
     *
     * @return ClientInterface
     */
    public function getClient(): ClientInterface;

    /**
     * Get framework information
     *
     * @return Framework
     */
    public function getFramework(): ?Framework;

    /**
     * Set using framework to config
     *
     * @param Framework $framework
     * @return mixed
     */
    public function setFramework(Framework $framework);

    /**
     * Get authenticated user
     *
     * @return User
     */
    public function getUser(): User;

    /**
     * Set authenticated user to config
     *
     * @param User $user
     * @return mixed
     */
    public function setUser(User $user);

    /**
     * @return AgentConfig
     */
    public function getAgentConfig(): AgentConfig;

    /**
     * Get registered metadata for this agent
     *
     * @return array
     */
    public function getMetadata(): array;

    /**
     * Set meta data for the agent
     *
     * @param array $data
     * @return mixed
     */
    public function setMetadata(array $data);
}
