<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorsBundle\JsonApi;

class ErrorSource
{
    private $pointer;
    private $parameter;

    public function __construct(?string $pointer = null, ?string $parameter = null)
    {
        $this->pointer = $pointer;
        $this->parameter = $parameter;
    }
}
