<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.03.15
 * Time: 16:36
 */

namespace Oro\Bundle\TrackerBundle\Tests\Unit\Entity;

use Composer\DependencyResolver\Problem;
use Oro\Bundle\TrackerBundle\Entity\Issue;
use Doctrine\Common\Collections\ArrayCollection;
use Oro\Bundle\TrackerBundle\Entity\Priority;

class PriorityTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new Priority();
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     */
    public function testSettersAndGetters($property, $value)
    {
        $obj = new Priority();

        call_user_func_array(array($obj, 'set' . ucfirst($property)), array($value));
        $this->assertEquals($value, call_user_func_array(array($obj, 'get' . ucfirst($property)), array()));
    }

    public function settersAndGettersDataProvider()
    {
        return array(
            array('name', Priority::PRIORITY_BLOCKER),
            array('label', Priority::PRIORITY_BLOCKER),
            array('order', '1')
        );
    }

    public function testToString() {
        $entity = new Priority();
        $entity->setLabel('111');
        $this->assertEquals($entity->getLabel(), (string)$entity);
    }
}