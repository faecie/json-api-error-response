<?php

declare(strict_types=1);

namespace Faecie\Bundle\JsonApiErrorResponseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const EXCEPTION_ATTRIBUTE_ID = 'id';
    public const EXCEPTION_ATTRIBUTE_ABOUT = 'about_link';
    public const EXCEPTION_ATTRIBUTE_STATUS = 'status';
    public const EXCEPTION_ATTRIBUTE_CODE = 'code';
    public const EXCEPTION_ATTRIBUTE_TITLE = 'title';
    public const EXCEPTION_ATTRIBUTE_DETAIL = 'detail';

    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder();
        $root = $tree->root('json_api_error_response');
        $root
            ->children()
            ->append($this->createExceptionsNode())
            ->end();

        return $tree;
    }

    private function createExceptionsNode(): ArrayNodeDefinition
    {
        $tree = new TreeBuilder();
        $node = $tree->root('exceptions');
        $node
            ->treatNullLike([])
            ->addDefaultsIfNotSet()
            ->children()
            ->arrayNode('response')
            ->defaultValue([])
            ->treatNullLike([])
            ->useAttributeAsKey('class')
            ->info('Exceptions characteristics being exposed as json in response to failed request')
            ->prototype('array')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultNull()
            ->info('FQCN of Exception class')
            ->end()
            ->scalarNode(self::EXCEPTION_ATTRIBUTE_ID)
            ->defaultNull()
            ->info('A unique identifier for this particular occurrence of the problem')
            ->end()
            ->scalarNode(self::EXCEPTION_ATTRIBUTE_ABOUT)
            ->defaultNull()
            ->info('A link that leads to further details' .
                ' about this particular occurrence of the problem.')
            ->end()
            ->integerNode(self::EXCEPTION_ATTRIBUTE_STATUS)
            ->defaultNull()
            ->info('The HTTP status code applicable to this problem')
            ->end()
            ->scalarNode(self::EXCEPTION_ATTRIBUTE_CODE)
            ->isRequired()
            ->info('An application-specific error code, expressed as a string value')
            ->end()
            ->scalarNode(self::EXCEPTION_ATTRIBUTE_TITLE)
            ->defaultNull()
            ->info('A short, human-readable summary of the problem that SHOULD NOT change ' .
                'from occurrence to occurrence of the problem, except for purposes of localization.')
            ->end()
            ->scalarNode(self::EXCEPTION_ATTRIBUTE_DETAIL)
            ->defaultNull()
            ->info('A human-readable explanation specific to this occurrence of the problem. ' .
                'Like title, this field’s value can be localized.')
            ->end()
            ->end()
            ->end()
            ->end();

        return $node;
    }
}
