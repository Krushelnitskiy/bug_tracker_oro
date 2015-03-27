<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.03.15
 * Time: 16:36
 */

namespace Oro\Bundle\TrackerBundle\Tests\Unit\Entity;

use Oro\Bundle\TrackerBundle\Entity\Resolution;
use Doctrine\Common\Collections\ArrayCollection;

class resolutionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new Resolution();
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     */
    public function testSettersAndGetters($property, $value)
    {
        $obj = new Resolution();

        call_user_func_array(array($obj, 'set' . ucfirst($property)), array($value));
        $this->assertEquals($value, call_user_func_array(array($obj, 'get' . ucfirst($property)), array()));
    }

    public function settersAndGettersDataProvider()
    {
        return array(
            array('name', Resolution::RESOLUTION_DONE),
            array('label', Resolution::RESOLUTION_DONE),
            array('order', '1')
        );
    }

    public function testToString() {
        $entity = new Resolution();
        $entity->setLabel('111');
        $this->assertEquals($entity->getLabel(), (string)$entity);
    }

}