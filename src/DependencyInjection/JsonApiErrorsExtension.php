<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorsBundle\DependencyInjection;

use Faecie\Bundle\JsonApiErrorsBundle\ExceptionDescriber\PreconfiguredExceptionsDescriber;
use Faecie\Bundle\JsonApiErrorsBundle\JsonApi\Error;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class JsonApiErrorsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/'));
        $loader->load('config.xml');

        $errorObjects = [];
        $exceptionsConfiguration = $config['exceptions']['response'];

        foreach ($exceptionsConfiguration as $exception => $config) {
            $errorObjects[$exception] = new Error(
                $config[Configuration::EXCEPTION_ATTRIBUTE_CODE],
                $config[Configuration::EXCEPTION_ATTRIBUTE_ID],
                $config[Configuration::EXCEPTION_ATTRIBUTE_ABOUT],
                $config[Configuration::EXCEPTION_ATTRIBUTE_STATUS],
                $config[Configuration::EXCEPTION_ATTRIBUTE_TITLE],
                $config[Configuration::EXCEPTION_ATTRIBUTE_DETAIL]
            );
        }

        $container->getDefinition(PreconfiguredExceptionsDescriber::class)
            ->replaceArgument(0, $exceptionsConfiguration);
    }
}
