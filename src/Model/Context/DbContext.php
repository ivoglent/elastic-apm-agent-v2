<?php

namespace Elastic\Apm\PhpAgent\Model\Context;

use Elastic\Apm\PhpAgent\Util\BaseObject;

class DbContext extends SpanContext
{
    /**
     * Database instance name
     *
     * @var string
     */
    protected $instance;

    /**
     * A database statement (e.g. query) for the given database type
     *
     * @var string
     */
    protected $statement;

    /**
     * Database type. For any SQL database, "sql". For others, the lower-case database category, e.g. "cassandra", "hbase", or "redis"
     *
     * @var string
     */
    protected $type;

    /**
     * Username for accessing database
     *
     * @var string
     */
    protected $username;

    /**
     * @param string $instance
     */
    public function setInstance(string $instance)
    {
        $this->instance = $instance;
    }

    /**
     * @param string $statement
     */
    public function setStatement(string $statement)
    {
        $this->statement = $statement;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'instance' => $this->instance,
            'statement' => $this->statement,
            'type' => $this->type,
            'username' => $this->username,
        ];
    }

    /**
     * Define object validation rules
     *
     * @return array
     */
    public function validationRules(): array
    {
        return [
            'required' => ['statement'],
        ];
    }
}
