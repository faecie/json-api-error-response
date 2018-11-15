<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle;

use Faecie\Bundle\JsonApiErrorResponseBundle\DependencyInjection\Compiler\ExceptionDescriberCompilerPass;
use Faecie\Bundle\JsonApiErrorResponseBundle\DependencyInjection\Compiler\RemoveOverwrittenServicesCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JsonApiErrorResponseBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ExceptionDescriberCompilerPass());
        $container->addCompilerPass(new RemoveOverwrittenServicesCompilerPass());
    }
}
