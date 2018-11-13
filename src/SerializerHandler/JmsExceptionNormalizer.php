<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorsBundle\SerializerHandler;

use Exception;
use Faecie\Bundle\JsonApiErrorsBundle\ExceptionDescriber\ExceptionDescriberInterface;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Faecie\Bundle\JsonApiErrorsBundle\Enum\ErrorCodesEnum;
use Throwable;
use Error;
use Faecie\Bundle\JsonApiErrorsBundle\JsonApi\Error as  JsonApiError;

/**
 * Class JmsExceptionNormalizer
 */
class JmsExceptionNormalizer implements SubscribingHandlerInterface
{
    private $exceptionDescriber;

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

    public function __construct(ExceptionDescriberInterface $describer)
    {
        $this->exceptionDescriber = $describer;
    }

    public function serializeToJson(
        JsonSerializationVisitor $visitor,
        Throwable $exception,
        array $type,
        Context $context
    ): array {
        return $visitor->visitArray($this->getInformation($exception), $type, $context);
    }

    private function getInformation(Throwable $exception): array
    {

        $errors = $this->exceptionDescriber->extractErrors($exception);

        if ($errors) {
            return ['errors' => $errors];
        }

        return ['errors' => [new JsonApiError(ErrorCodesEnum::INTERNAL)]];
    }
}
