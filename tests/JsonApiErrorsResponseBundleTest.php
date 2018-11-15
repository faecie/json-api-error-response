<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\Test;

use Faecie\Bundle\JsonApiErrorResponseBundle\JsonApiErrorResponseBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class JsonApiErrorsResponseBundleTest extends TestCase
{
    public function testBuild(): void
    {
        $bundle = new JsonApiErrorResponseBundle();
        $containerMock = $this->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $containerMock->expects(self::exactly(2))->method('addCompilerPass');
        $bundle->build($containerMock);
    }
}

