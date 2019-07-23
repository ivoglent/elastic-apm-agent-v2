<?php
namespace Elastic\Apm\PhpAgent\Interfaces;


interface ModelInterface extends \JsonSerializable
{

    /**
     * Get object's json encoded information
     *
     * @return string
     */
    public function getJsonData(): string;

    /**
     * @return array
     */
    public function toArray(): array ;

    /**
     * Validate object properties
     *
     * @return bool
     */
    public function validate(): bool ;

    /**
     * Define object validation rules
     *
     * @return array
     */
    public function validationRules(): array ;
}