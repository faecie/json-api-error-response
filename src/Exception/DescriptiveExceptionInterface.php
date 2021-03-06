<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\Exception;

use Faecie\Bundle\JsonApiErrorResponseBundle\JsonApi\Error;
use Throwable;

interface DescriptiveExceptionInterface extends Throwable
{
    /**
     * Returns list of errors in format compliant with error objects format in jsonapi v1.0
     *
     * @return Error[]
     * @link http://jsonapi.org/format/#errors
     * @see  Error
     */
    public function getErrors(): array;
}
