<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber;

use Faecie\Bundle\JsonApiErrorResponseBundle\JsonApi\Error;
use Throwable;

/**
 * Class PreconfiguredExceptionExtractor
 */
class PreconfiguredExceptionsDescriber implements ExceptionDescriberInterface
{
    private $exceptionErrorMap;

    public function __construct(array $exceptionErrorMap)
    {
        $this->exceptionErrorMap = $exceptionErrorMap;
    }

    public function extractErrors(Throwable $exception): array
    {
        $error = $this->getErrorForException($exception);

        return $error ? [$error] : [];
    }

    private function getErrorForException(Throwable $exception): ?Error
    {
        $class = $originalClass = get_class($exception);

        do {
            if (isset($this->exceptionErrorMap[$class])) {
                $this->exceptionErrorMap[$originalClass] = $this->exceptionErrorMap[$class];

                return $this->exceptionErrorMap[$class];
            }

            $class = get_parent_class($class);
        } while ($class);

        return null;
    }
}
