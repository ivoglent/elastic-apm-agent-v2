<?php


namespace Elastic\Apm\PhpAgent\Model\Context;


use Elastic\Apm\PhpAgent\Util\BaseObject;

class DbContext extends BaseObject
{
    /**
     * Database instance name
     *
     * @var string
     */
    private $instance;

    /**
     * A database statement (e.g. query) for the given database type
     *
     * @var string
     */
    private $statement;

    /**
     * Database type. For any SQL database, "sql". For others, the lower-case database category, e.g. "cassandra", "hbase", or "redis"
     *
     * @var string
     */
    private $type;

    /**
     * Username for accessing database
     *
     * @var string
     */
    private $username;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'instance' => $this->instance,
            'statement' => $this->statement,
            'type' => $this->type,
            'username' => $this->username
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
            'required' => ['statement']
        ];
    }
}