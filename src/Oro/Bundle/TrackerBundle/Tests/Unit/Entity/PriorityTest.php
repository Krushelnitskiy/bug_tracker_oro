<?php

namespace Oro\Bundle\TrackerBundle\Tests\Unit\Entity;

use Symfony\Component\PropertyAccess\PropertyAccess;

use Oro\Bundle\TrackerBundle\Entity\Priority;

class PriorityTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new Priority();
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     * @param $property
     * @param $value
     */
    public function testSettersAndGetters($property, $value)
    {
        $obj = new Priority();
        $accessor = PropertyAccess::createPropertyAccessor();
        $accessor->setValue($obj, $property, $value);
        $this->assertEquals($value, $accessor->getValue($obj, $property), array());
    }

    public function settersAndGettersDataProvider()
    {
        return array(
            array('name', Priority::PRIORITY_BLOCKER),
            array('label', Priority::PRIORITY_BLOCKER),
            array('order', '1')
        );
    }

//    public function testToString()
//    {
//        $entity = new Priority();
//        $entity->setLabel('111');
//        $this->assertEquals($entity->getLabel(), (string)$entity);
//    }
}
