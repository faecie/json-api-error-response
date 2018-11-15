<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber;

use Faecie\Bundle\JsonApiErrorResponseBundle\JsonApi\Error;
use Throwable;

interface ExceptionDescriberInterface
{
    /**
     * @return Error[]
     */
    public function extractErrors(Throwable $exception): array;
}
