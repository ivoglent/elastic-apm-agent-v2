<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/22/19
 * Time: 5:43 PM
 */

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;
use Elastic\Apm\PhpAgent\Interfaces\TimedInterface;

class Span extends AbstractModel implements ModelInterface, TimedInterface
{
    /**
     * Duration of the span in milliseconds
     *
     * @var int
     */
    private $duration;

    /**
     * Generic designation of a span in the scope of a transaction
     *
     * @var string
     */
    private $name;

    /**
     * List of stack frames with variable attributes (eg: lineno, filename, etc)
     *
     * @ref "../stacktrace_frame.json"
     *
     * @var mixed array | null
     */
    private $stacktrace;

    /**
     * Keyword of specific relevance in the service's domain (eg: 'db.postgresql.query', 'template.erb', etc)
     *
     * @var string
     */
    private $type;


    /**
     * Indicates whether the span was executed synchronously or asynchronously.
     *
     * @var bool
     */
    private $sync = false;

    /**
     * Offset relative to the transaction's timestamp identifying the start of the span, in milliseconds
     *
     * @var int
     */
    private $start;

    /**
     * A further sub-division of the type (e.g. postgresql, elasticsearch)
     *
     * @var string
     */
    private $subtype;

    /**
     * Span Contexts
     *
     * @var array
     */
    private $contexts = [];

    /**
     * The specific kind of event within the sub-type represented by the span (e.g. query, connect)
     *
     * @var string
     */
    private $action = null;

    /**
     * Span constructor.
     * @param string $name
     * @param string $type
     * @param bool $sync
     * @param string $subtype
     * @param string $action
     * @internal param int $start
     */
    public function __construct(string $name, string $type, ?bool $sync = true, ?string $subtype, ?string $action)
    {
        $this->name = $name;
        $this->type = $type;
        $this->sync = $sync;
        $this->subtype = $subtype;
        $this->action = $action;
    }


    /**
     * Get object's json encoded information
     *
     * @return string
     */
    public function getJsonData(): string
    {
        // TODO: Implement getJsonData() method.
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }
}