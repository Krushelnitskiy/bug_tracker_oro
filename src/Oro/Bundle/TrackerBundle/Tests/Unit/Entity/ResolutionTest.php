<?php

namespace Oro\Bundle\TrackerBundle\Tests\Unit\Entity;

use Symfony\Component\PropertyAccess\PropertyAccess;

use Oro\Bundle\TrackerBundle\Entity\Resolution;

class ResolutionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new Resolution();
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     * @param $property
     * @param $value
     */
    public function testSettersAndGetters($property, $value)
    {
        $obj = new Resolution();
        $accessor = PropertyAccess::createPropertyAccessor();
        $accessor->setValue($obj, $property, $value);
        $this->assertEquals($value, $accessor->getValue($obj, $property), array());
    }

    public function settersAndGettersDataProvider()
    {
        return array(
            array('name', Resolution::RESOLUTION_DONE),
            array('label', Resolution::RESOLUTION_DONE),
            array('order', '1')
        );
    }

    public function testToString()
    {
        $entity = new Resolution();
        $entity->setLabel('111');
        $this->assertEquals($entity->getLabel(), (string)$entity);
    }
}
