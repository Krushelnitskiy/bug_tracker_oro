<?php

namespace Oro\Bundle\TrackerBundle\Tests\Unit\Form\Type;

use Oro\Bundle\TrackerBundle\Form\Type\IssueType;
use Oro\Bundle\UserBundle\Entity\User;

class IssueTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IssueType
     */
    protected $formType;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $securityContext;

    protected function setUp()
    {
        $mockToken = true;
        $mockUser = true;
        $newUser = new User();
        $newUser->setFirstName('newUser');
        $this->mockSecurityContext($mockToken, $mockUser, $newUser);
        $this->formType = new IssueType($this->securityContext);
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

        $builder->expects($this->exactly(7))
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
                    'code',
                    'summary',
                    'description',
                    'assignee',
                    'owner',
                    'priority',
                    'tags'
                ]
            ]
        ];
    }

    public function testGetName()
    {
        $this->assertEquals('orotracker_issue', $this->formType->getName());
    }

    /**
     * @param bool $mockToken
     * @param bool $mockUser
     * @param User|null $user
     */
    protected function mockSecurityContext($mockToken = false, $mockUser = false, $user = null)
    {
        $securityContext = $this->getMockBuilder('Symfony\Component\Security\Core\SecurityContextInterface')
            ->setMethods(array('getToken'))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        if ($mockToken) {
            $token = $this->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\TokenInterface')
                ->setMethods(array('getUser'))
                ->disableOriginalConstructor()
                ->getMockForAbstractClass();

            if ($mockUser) {
                $token->expects($this->any())
                    ->method('getUser')
                    ->will($this->returnValue($user));
            }

            $securityContext->expects($this->any())
                ->method('getToken')
                ->will($this->returnValue($token));
        }

        $this->securityContext = $securityContext;
    }
}
