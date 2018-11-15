<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\Test\ExceptionDescriber;

use Exception;
use Faecie\Bundle\JsonApiErrorResponseBundle\Exception\DescriptiveExceptionInterface;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\DescriptiveExceptionDescriber;
use Faecie\Bundle\JsonApiErrorResponseBundle\JsonApi\Error;
use PHPUnit\Framework\TestCase;

class DescriptiveExceptionDescriberTest extends TestCase
{

    public function testExtractErrorsWithWriteException(): void
    {
        $expectedErrors = [
            new Error(
                'some_unique_code',
                'teapot',
                'I am a tea pot',
                418,
                'TeaPot',
                'You can not boil cofee in a teapot',
                'can.type',
                'coffee'
            ),
        ];
        $describer = new DescriptiveExceptionDescriber();
        $errors = $describer->extractErrors(new class ($expectedErrors) extends Exception implements DescriptiveExceptionInterface
        {
            private $errors;

            public function __construct(array $errors)
            {
                $this->errors = $errors;
            }

            public function getErrors(): array
            {
                return $this->errors;
            }
        });

        $this->assertSame($expectedErrors, $errors);
    }

    public function testExtractErrorsWithWrongExceptionReturnsEmpty(): void
    {
        $describer = new DescriptiveExceptionDescriber();
        $errors = $describer->extractErrors(new Exception());

        $this->assertEmpty($errors);
    }
}

