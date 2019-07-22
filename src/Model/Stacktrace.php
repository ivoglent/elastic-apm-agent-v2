<?php
/**
 * Created by PhpStorm.
 * User: long.nguyenviet
 * Date: 7/22/19
 * Time: 6:35 PM
 */

namespace Elastic\Apm\PhpAgent\Model;


use Elastic\Apm\PhpAgent\Interfaces\ModelInterface;

class Stacktrace implements ModelInterface
{
    /**
     * Basename of tracing file
     *
     * @var string
     */
    private $filename;

    /**
     * Line number
     *
     * @var integer
     */
    private $lineno;

    /**
     * Called function
     *
     * @var string
     */
    private $function;

    /**
     * Absolute path to file
     *
     * @var string
     */
    private $abs_path;

    /**
     * Column number
     *
     * @var int
     */
    private $colno;

    /**
     * A boolean, indicating if this frame is from a library or user code
     *
     * @var bool
     */
    private $library_frame;
    /**
     * Get object's json encoded information
     *
     * @return string
     */

    /**
     * The module to which frame belongs to
     *
     * @var string
     */
    private $module;

    /**
     * The lines of code after the stack frame
     *
     * @var string
     */
    private $post_context;

    /**
     * The lines of code before the stack frame
     *
     * @var string
     */
    private $pre_context;

    /**
     * Local variables for this stack frame
     *
     * @var object
     */
    private $vars;

    /**
     * The line of code part of the stack frame
     *
     * @var string
     */
    private $context_line;

    /**
     * Stacktrace constructor.
     * @param string $filename
     * @param int $lineno
     * @param string $function
     * @param string $abs_path
     * @param int $colno
     * @param bool|null|string $library_frame
     * @param string $module
     * @param string $post_context
     * @param string $pre_context
     * @param array|null|object $vars
     * @param bool|null|string $context_line
     */
    public function __construct(string $filename, int $lineno, string $function, string $abs_path, int $colno, ?string $library_frame, ?string $module, ?string $post_context, ?string $pre_context, ?array $vars, ?bool $context_line)
    {
        $this->filename = $filename;
        $this->lineno = $lineno;
        $this->function = $function;
        $this->abs_path = $abs_path;
        $this->colno = $colno;
        $this->library_frame = $library_frame;
        $this->module = $module;
        $this->post_context = $post_context;
        $this->pre_context = $pre_context;
        $this->vars = $vars;
        $this->context_line = $context_line;
    }

    /**
     * @return string
     */
    public function getJsonData(): string
    {
        return \json_encode($this->toArray(), JSON_FORCE_OBJECT);
    }

    /**
     * Map the Stacktrace to Schema
     *
     * @param array $traces
     * @return Stacktrace[]
     */
    public static function mapStacktrace(array $traces) : array
    {
        /** @var Stacktrace[] $stacktraces */
        $stacktraces = [];
        foreach ($traces as $trace) {
            $item = [
                'function' => $trace['function'] ?? '(closure)'
            ];

            if (isset($trace['line']) === true) {
                $item['lineno'] = $trace['line'];
            }

            if (isset($trace['column']) === true) {
                $item['colno'] = $trace['column'];
            }

            if (isset($trace['file']) === true) {
                $item['filename'] = basename($trace['file']);
                $item['abs_path'] = ($trace['file']);
            }

            if (isset($trace['class']) === true) {
                $item['module'] = $trace['class'];
            }


            if (!isset($item['lineno'])) {
                $item['lineno'] = 0;
            }

            if (!isset($item['filename'])) {
                $item['filename'] = '(anonymous)';
            }
            $stacktraces[] =  new self($item['filename'], $item['lineno'], $item['function'], $item['abs_path'], $item['colno']);
        }
        return $stacktraces;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'filename' => $this->filename,
            'lineno' => $this->lineno,
            'function' => $this->function,
            'abs_path' => $this->abs_path,
            'colno' => $this->colno,
            'library_frame' => $this->library_frame,
            'module' => $this->module,
            'post_context' => $this->post_context,
            'pre_context' => $this->pre_context,
            'vars' => $this->vars,
            'context_line' => $this->context_line
        ];
    }
}