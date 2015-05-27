<?php

namespace Oro\Bundle\TrackerBundle\Tests\Unit\DependencyInjection;

use Oro\Bundle\TrackerBundle\DependencyInjection\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfigTreeBuilder()
    {
        $configuration = new Configuration();
        $builder       = $configuration->getConfigTreeBuilder();

        $this->assertInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder', $builder);
    }
}
