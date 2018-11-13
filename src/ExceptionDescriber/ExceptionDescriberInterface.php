<?php

declare(strict_types = 1);

namespace Faecie\Bundle\JsonApiErrorsBundle\ExceptionDescriber;

use Faecie\Bundle\JsonApiErrorsBundle\JsonApi\Error;
use Throwable;

interface ExceptionDescriberInterface
{
    /**
     * @return Error[]
     */
    public function extractErrors(Throwable $exception): array;
}
