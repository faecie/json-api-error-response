<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\DependencyInjection\Compiler;

use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\DescriptiveExceptionDescriber;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\ExceptionDescriberInterface;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\ExceptionDescribersQueue;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\SymfonyExceptionDescriber;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ExceptionDescriberCompilerPass
 */
class ExceptionDescriberCompilerPass implements CompilerPassInterface
{
    /**
     * Tag for services
     */
    public const TAG_NAME = 'json_api.exception_describer';

    public function process(ContainerBuilder $container)
    {
        $references = [];
        $references[] = new Reference(DescriptiveExceptionDescriber::class);
        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $serviceId => $tagsAttributes) {
            $definition = $container->findDefinition($serviceId);
            $class = $definition->getClass();
            $implements = class_implements($definition->getClass());
            if (! isset($implements[ExceptionDescriberInterface::class])) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Service "%s" with class "%s" must implement interface "%s"',
                        $serviceId,
                        $class,
                        ExceptionDescriberInterface::class
                    )
                );
            }

            $references[] = new Reference($serviceId);
        }

        $references[] = new Reference(SymfonyExceptionDescriber::class);

        $container->getDefinition(ExceptionDescribersQueue::class)
            ->replaceArgument(0, $references);
    }
}
