<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorsBundle;

use Faecie\Bundle\JsonApiErrorsBundle\DependencyInjection\Compiler\RemoveOverwrittenServicesCompilerPass;
use Faecie\Bundle\JsonApiErrorsBundle\DependencyInjection\Compiler\ExceptionDescriberCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JsonApiErrorsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ExceptionDescriberCompilerPass());
        $container->addCompilerPass(new RemoveOverwrittenServicesCompilerPass());
    }
}
