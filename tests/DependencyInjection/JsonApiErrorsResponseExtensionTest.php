<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\Test\DependencyInjection;

use Error;
use Exception;
use Faecie\Bundle\JsonApiErrorResponseBundle\DependencyInjection\Compiler\ExceptionDescriberCompilerPass;
use Faecie\Bundle\JsonApiErrorResponseBundle\DependencyInjection\Configuration;
use Faecie\Bundle\JsonApiErrorResponseBundle\DependencyInjection\JsonApiErrorResponseExtension;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\DescriptiveExceptionDescriber;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\ExceptionDescribersQueue;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\PreconfiguredExceptionsDescriber;
use Faecie\Bundle\JsonApiErrorResponseBundle\ExceptionDescriber\SymfonyExceptionDescriber;
use Faecie\Bundle\JsonApiErrorResponseBundle\JsonApiErrorResponseBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class JsonApiErrorsResponseExtensionTest extends TestCase
{
    public function testExceptionsConfigurationLOaded()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('json_api_error_response', [
            'exceptions' => [
                'response' => [
                    Exception::class => [
                        Configuration::EXCEPTION_ATTRIBUTE_ID => 'someTest',
                        Configuration::EXCEPTION_ATTRIBUTE_CODE => 'someUniqueCode',
                    ],
                    Error::class => [
                        Configuration::EXCEPTION_ATTRIBUTE_ID => 'someTest1',
                        Configuration::EXCEPTION_ATTRIBUTE_CODE => 'someUniqueCode2',
                    ],
                ],
            ],
        ]);

        $container->compile();
        $definition = $container->getDefinition(PreconfiguredExceptionsDescriber::class);
        $this->assertArraySubset([Exception::class, Error::class], array_keys($definition->getArguments()[0]));
    }

    public function testAllDescribersAddedToQueue(): void
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('json_api_error_response', []);

        $definition = new Definition(PreconfiguredExceptionsDescriber::class, [[]]);
        $definition->addTag(ExceptionDescriberCompilerPass::TAG_NAME);
        $container->setDefinition('test.describer.to.pass.to.queue.describer', $definition);

        $container->compile();
        $definition = $container->getDefinition(ExceptionDescribersQueue::class);
        $arguments = $definition->getArguments();
        $this->assertSame(
            trim(DescriptiveExceptionDescriber::class, '\\'),
            $arguments[0][0]->__toString(),
            'The first describer in the que should be the one who obtains description right from the exception'
        );
        $this->assertSame(
            'test.describer.to.pass.to.queue.describer',
            $arguments[0][1]->__toString(),
            'Next describer should be that user defines tagged her services by ' . ExceptionDescriberCompilerPass::TAG_NAME
        );
        $this->assertSame(
            trim(SymfonyExceptionDescriber::class, '\\'),
            $arguments[0][2]->__toString(),
            'The last descriptor should be inner system predefined list of symfony exceptions'
        );
    }

    /**
     * @expectedException \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    public function testWrongButTaggedDescribersNotAddedToQueue(): void
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('json_api_error_response', []);

        $definition = new Definition(Exception::class);
        $definition->addTag(ExceptionDescriberCompilerPass::TAG_NAME);
        $container->setDefinition('test.describer.to.pass.to.queue.describer', $definition);

        $container->compile();
    }

    protected function getRawContainer(): ContainerBuilder
    {
        $container = new ContainerBuilder();
        $security = new JsonApiErrorResponseExtension();
        $container->registerExtension($security);

        $bundle = new JsonApiErrorResponseBundle();
        $bundle->build($container);

        $container->getCompilerPassConfig()->setOptimizationPasses([]);
        $container->getCompilerPassConfig()->setRemovingPasses([]);

        return $container;
    }
}

