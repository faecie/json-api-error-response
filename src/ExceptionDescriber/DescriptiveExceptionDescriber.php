<?php

declare(strict_types = 1);

namespace Faecie\Bundle\JsonApiErrorsBundle\ExceptionDescriber;

use Faecie\Bundle\JsonApiErrorsBundle\Exception\DescriptiveExceptionInterface;
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
