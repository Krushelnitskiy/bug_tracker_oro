<?php

namespace Oro\Bundle\TrackerBundle\Tests\Unit\Form\Type;

use Oro\Bundle\TrackerBundle\Form\Type\IssueType;

class IssueTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TaskType
     */
    protected $formType;

    protected function setUp()
    {
        $this->formType = new IssueType();
    }

    /**
     * @param array $widgets
     *
     * @dataProvider formTypeProvider
     */
    public function testBuildForm(array $widgets)
    {
        $builder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $builder->expects($this->exactly(5))
            ->method('add')
            ->will($this->returnSelf());

        foreach ($widgets as $key => $widget) {
            $builder->expects($this->at($key))
                ->method('add')
                ->with($this->equalTo($widget))
                ->will($this->returnSelf());
        }

        $this->formType->buildForm($builder, []);
    }

    public function formTypeProvider()
    {
        return [
            'all' => [
                'widgets' => [
                    'summary',
                    'description',
                    'reporter',
                    'owner',
                    'priority'
                ]
            ]
        ];
    }

    public function testGetName()
    {
        $this->assertEquals('orotracker_issue', $this->formType->getName());
    }
}
