<?php

namespace Elastic\Apm\PhpAgent\Model;

use Elastic\Apm\PhpAgent\Util\BaseObject;

class Stacktrace extends BaseObject
{
    /**
     * Basename of tracing file
     *
     * @var string
     */
    protected $filename;

    /**
     * Line number
     *
     * @var int
     */
    protected $lineno;

    /**
     * Called function
     *
     * @var string
     */
    protected $function;

    /**
     * Absolute path to file
     *
     * @var string
     */
    protected $abs_path;

    /**
     * Column number
     *
     * @var int
     */
    protected $colno;

    /**
     * A boolean, indicating if this frame is from a library or user code
     *
     * @var bool
     */
    protected $library_frame;
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
    protected $module;

    /**
     * The lines of code after the stack frame
     *
     * @var string
     */
    protected $post_context;

    /**
     * The lines of code before the stack frame
     *
     * @var string
     */
    protected $pre_context;

    /**
     * Local variables for this stack frame
     *
     * @var object
     */
    protected $vars;

    /**
     * The line of code part of the stack frame
     *
     * @var string
     */
    protected $context_line;

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return int
     */
    public function getLineno(): int
    {
        return $this->lineno;
    }

    /**
     * @return string
     */
    public function getFunction(): string
    {
        return $this->function;
    }

    /**
     * @return string
     */
    public function getAbsPath(): string
    {
        return $this->abs_path;
    }

    /**
     * @return int
     */
    public function getColno(): int
    {
        return $this->colno;
    }

    /**
     * @return bool
     */
    public function isLibraryFrame(): bool
    {
        return $this->library_frame;
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @return string
     */
    public function getPostContext(): string
    {
        return $this->post_context;
    }

    /**
     * @return string
     */
    public function getPreContext(): string
    {
        return $this->pre_context;
    }

    /**
     * @return object
     */
    public function getVars(): object
    {
        return $this->vars;
    }

    /**
     * @return string
     */
    public function getContextLine(): string
    {
        return $this->context_line;
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
    public static function mapStacktrace(array $traces): array
    {
        /** @var Stacktrace[] $stacktraces */
        $stacktraces = [];
        foreach ($traces as $trace) {
            $item = [
                'function' => $trace['function'] ?? '(closure)',
            ];

            if (true === isset($trace['line'])) {
                $item['lineno'] = $trace['line'];
            }

            if (true === isset($trace['column'])) {
                $item['colno'] = $trace['column'];
            }

            if (true === isset($trace['file'])) {
                $item['filename'] = basename($trace['file']);
                $item['abs_path'] = ($trace['file']);
            }

            if (true === isset($trace['class'])) {
                $item['module'] = $trace['class'];
            }

            if (!isset($item['lineno'])) {
                $item['lineno'] = 0;
            }

            if (!isset($item['filename'])) {
                $item['filename'] = '(anonymous)';
            }
            $stacktraces[] = new self($item['filename'], $item['lineno'], $item['function'], $item['abs_path'], $item['colno']);
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
            'context_line' => $this->context_line,
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
            'required' => ['filename'],
        ];
    }
}
