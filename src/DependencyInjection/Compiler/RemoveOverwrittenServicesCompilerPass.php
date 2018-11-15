<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RemoveOverwrittenServicesCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $servicesToRemove = ['fos_rest.serializer.exception_normalizer.jms'];

        foreach ($servicesToRemove as $serviceId) {
            $container->removeDefinition($serviceId);
        }
    }
}
