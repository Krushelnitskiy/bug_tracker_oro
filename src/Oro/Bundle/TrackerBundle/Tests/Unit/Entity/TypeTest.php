<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.03.15
 * Time: 16:36
 */

namespace Oro\Bundle\TrackerBundle\Tests\Unit\Entity;

use Oro\Bundle\TrackerBundle\Entity\Type;
use Doctrine\Common\Collections\ArrayCollection;

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

        call_user_func_array(array($obj, 'set' . ucfirst($property)), array($value));
        $this->assertEquals($value, call_user_func_array(array($obj, 'get' . ucfirst($property)), array()));
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
