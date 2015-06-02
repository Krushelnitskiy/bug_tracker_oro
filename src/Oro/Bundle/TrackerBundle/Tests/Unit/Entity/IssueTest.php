<?php

namespace Oro\Bundle\TrackerBundle\Tests\Unit\Entity;

use Oro\Bundle\TrackerBundle\Entity\Issue;

class IssueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new Issue();
    }

    public function testGetSetWorkflowItem()
    {
        $entity = new Issue();
        $workflowItem = $this->getMock('Oro\Bundle\WorkflowBundle\Entity\WorkflowItem');

        $this->assertNull($entity->getWorkflowItem());

        $entity->setWorkflowItem($workflowItem);

        $this->assertEquals($workflowItem, $entity->getWorkflowItem());
    }

    public function testGetSetWorkflowStep()
    {
        $entity = new Issue();
        $workflowStep = $this->getMock('Oro\Bundle\WorkflowBundle\Entity\WorkflowStep');

        $this->assertNull($entity->getWorkflowStep());

        $entity->setWorkflowStep($workflowStep);

        $this->assertEquals($workflowStep, $entity->getWorkflowStep());
    }

    public function testGetWorkflowStep()
    {
        $entity = new Issue();
        $workflowStep = $this->getMock('Oro\Bundle\WorkflowBundle\Entity\WorkflowStep');

        $this->assertNull($entity->getWorkflowStep());

        $entity->setWorkflowStep($workflowStep);

        $this->assertEquals($workflowStep, $entity->getWorkflowStep());
    }

    public function testSetOwner()
    {
        $entity = new Issue();

        $this->assertNull($entity->getOwner());

        $user = $this->getMock('Oro\Bundle\UserBundle\Entity\User');
        $entity->setOwner($user);

        $this->assertEquals($user, $entity->getOwner());
    }

    public function testGetOwnerId()
    {
        $entity = new Issue();

        $this->assertNull($entity->getOwner());
        /**
         * @var $user \PHPUnit_Framework_MockObject_MockObject
         */
        $user = $this->getMock('Oro\Bundle\UserBundle\Entity\User');
        $expected = 1;
        $user->expects($this->once())->method('getId')->will($this->returnValue($expected));

        $entity->setOwner($user);
        $this->assertEquals($expected, $entity->getOwner()->getId());
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     * @param $property
     * @param $value
     */
    public function testSettersAndGetters($property, $value)
    {
        $obj = new Issue();

        call_user_func_array(array($obj, 'set' . ucfirst($property)), array($value));
        $this->assertEquals($value, call_user_func_array(array($obj, 'get' . ucfirst($property)), array()));
    }

    public function settersAndGettersDataProvider()
    {
        $testIssuePriority = $this->getMockBuilder('Oro\Bundle\TrackerBundle\Entity\Priority')
            ->disableOriginalConstructor()
            ->getMock();

        $testIssuePriority->expects($this->once())->method('getName')->will($this->returnValue('low'));
        $testIssuePriority->expects($this->once())->method('getLabel')->will($this->returnValue('Low label'));

        $testIssueType = $this->getMockBuilder('Oro\Bundle\TrackerBundle\Entity\Type')
            ->disableOriginalConstructor()
            ->getMock();
        $testIssueType->expects($this->once())->method('getName')->will($this->returnValue('Story'));
        $testIssueType->expects($this->once())->method('getLabel')->will($this->returnValue('Story'));

        $testIssueResolution = $this->getMockBuilder('Oro\Bundle\TrackerBundle\Entity\Resolution')
            ->disableOriginalConstructor()
            ->getMock();
        $testIssueResolution->expects($this->once())->method('getName')->will($this->returnValue('Fixed'));
        $testIssueResolution->expects($this->once())->method('getLabel')->will($this->returnValue('Fixed'));

        $testAssignee = $this->getMock('Oro\Bundle\UserBundle\Entity\User');
        $testOwner = $this->getMock('Oro\Bundle\UserBundle\Entity\User');

        $organization = $this->getMock('Oro\Bundle\OrganizationBundle\Entity\Organization');
        $parent = new Issue();

        return array(
            array('summary', 'Test summary'),
            array('description', 'Test Description'),
            array('code', '111111'),
            array('priority', $testIssuePriority),
            array('resolution', $testIssueResolution),
            array('assignee', $testAssignee),
            array('owner', $testOwner),
            array('parent', $parent),
            array('type', $testIssueType),
            array('createdAt', new \DateTime()),
            array('updatedAt', new \DateTime()),
            array('organization', $organization, $organization)
        );
    }

    public function testCollaborator()
    {
        $entity = new Issue();
        $testCollaborator = $this->getMock('Oro\Bundle\UserBundle\Entity\User');
        $entity->addCollaborator($testCollaborator);
        $this->assertCount(1, $entity->getCollaborators());
        $entity->removeCollaborator($testCollaborator);
        $this->assertCount(0, $entity->getCollaborators());
    }

    public function testChildren()
    {
        $entity = new Issue();
        $entityChildren = new Issue();

        $this->assertCount(0, $entity->getChildren());
        $entity->addChild($entityChildren);
        $this->assertCount(1, $entity->getChildren());
        $entity->removeChild($entityChildren);
        $this->assertCount(0, $entity->getChildren());
    }
}
