<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber;

use Faecie\Bundle\JsonApiErrorResponseBundle\Exception\DescriptiveExceptionInterface;
use Throwable;

class DescriptiveExceptionDescriber implements ExceptionDescriberInterface
{
    public function extractErrors(Throwable $exception): array
    {
        if ($exception instanceof DescriptiveExceptionInterface) {
            return $exception->getErrors();
        }

        return [];
    }
}
