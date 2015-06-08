<?php

namespace Oro\Bundle\TrackerBundle\Tests\Unit\Entity;

use Symfony\Component\PropertyAccess\PropertyAccess;

use Oro\Bundle\TrackerBundle\Entity\Type;

class TypeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new Type();
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     * @param $property
     * @param $value
     */
    public function testSettersAndGetters($property, $value)
    {
        $obj = new Type();
        $accessor = PropertyAccess::createPropertyAccessor();
        $accessor->setValue($obj, $property, $value);
        $this->assertEquals($value, $accessor->getValue($obj, $property), array());
    }

    public function settersAndGettersDataProvider()
    {
        return array(
            array('name', Type::TYPE_SUB_TASK),
            array('label', Type::TYPE_SUB_TASK),
            array('order', '1')
        );
    }

    public function testToString()
    {
        $entity = new Type();
        $entity->setLabel('111');
        $this->assertEquals($entity->getLabel(), (string)$entity);
    }
}
