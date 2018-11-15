<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\SerializerHandler;

use Error;
use Exception;
use Faecie\Bundle\JsonApiErrorResponseBundle\Enum\ErrorCodesEnum;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\ExceptionDescriberInterface;
use Faecie\Bundle\JsonApiErrorResponseBundle\JsonApi\Error as JsonApiError;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Throwable;

/**
 * Class JmsExceptionNormalizer
 */
class JmsExceptionNormalizer implements SubscribingHandlerInterface
{
    private $exceptionDescriber;

    public function __construct(ExceptionDescriberInterface $describer)
    {
        $this->exceptionDescriber = $describer;
    }

    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => Exception::class,
                'method' => 'serializeToJson',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => Error::class,
                'method' => 'serializeToJson',
            ],
        ];
    }

    public function serializeToJson(
        JsonSerializationVisitor $visitor,
        Throwable $exception,
        array $type,
        Context $context
    ): iterable {
        return $visitor->visitArray($this->getInformation($exception), $type, $context);
    }

    private function getInformation(Throwable $exception): array
    {

        $errors = $this->exceptionDescriber->extractErrors($exception);

        if (! empty($errors)) {
            return ['errors' => $errors];
        }

        return ['errors' => [new JsonApiError(ErrorCodesEnum::INTERNAL)]];
    }
}
