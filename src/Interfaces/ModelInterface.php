<?php

namespace Elastic\Apm\PhpAgent\Interfaces;


interface ModelInterface
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
}