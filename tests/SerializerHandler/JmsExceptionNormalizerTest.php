<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\Test\SerializerHandler;

use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\SymfonyExceptionDescriber;
use Faecie\Bundle\JsonApiErrorResponseBundle\JsonApi\Error as JsonApiError;
use Faecie\Bundle\JsonApiErrorResponseBundle\SerializerHandler\JmsExceptionNormalizer;
use JMS\Serializer\Context;
use JMS\Serializer\JsonSerializationVisitor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Error;
use Exception;
use Throwable;

class JmsExceptionNormalizerTest extends TestCase
{
    /**
     * @dataProvider getExceptions
     */
    public function testSerializeToJson(Throwable $exception)
    {
        $describer = new SymfonyExceptionDescriber();
        $serializer = new JmsExceptionNormalizer($describer);
        $visitorMock = $this->getMockBuilder(JsonSerializationVisitor::class)
            ->disableOriginalConstructor()
            ->getMock();
        $visitorMock->expects(self::once())->method('visitArray')->willReturnCallback(
            function (array $array, $type, $context) {
                $this->assertInstanceOf(JsonApiError::class, $array['errors'][0]);
                return $array;
            }
        );

        $serializer->serializeToJson(
            $visitorMock,
            $exception,
            [],
            $this->prophesize(Context::class)->reveal()
        );
    }

    public function testGetSubscribingMethods()
    {
        $methods = JmsExceptionNormalizer::getSubscribingMethods();

        $expectedTypes = [Exception::class, Error::class];

        foreach ($methods as $method) {
            $this->assertContains($method['type'],  $expectedTypes);
        }
    }

    public function getExceptions(): array
    {
        return [
            "Exception that's extending preconfigured Symfony exception should pass"  => [
                new class extends BadRequestHttpException {},
            ],
            'Even plain unknown exception should pass' => [
                new class extends Error {},
            ]
        ];
    }
}

