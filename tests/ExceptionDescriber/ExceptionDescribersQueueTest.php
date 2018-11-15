<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\Test\ExceptionDescriber;

use Exception;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\ExceptionDescribersQueue;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\PreconfiguredExceptionsDescriber;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\SymfonyExceptionDescriber;
use Faecie\Bundle\JsonApiErrorResponseBundle\JsonApi\Error;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ExceptionDescribersQueueTest extends TestCase
{
    public function testExtractErrors(): void
    {
        $describer = new ExceptionDescribersQueue([]);
        $this->assertEmpty($describer->extractErrors(new Exception()));
    }

    public function testDescribeErrorsByFirstAvailableDescriber(): void
    {
        $describer = new ExceptionDescribersQueue([
            new PreconfiguredExceptionsDescriber([]),
            new SymfonyExceptionDescriber(),
        ]);

        $errors = $describer->extractErrors(new BadRequestHttpException());
        $this->assertInstanceOf(Error::class, $errors[0]);

    }
}

