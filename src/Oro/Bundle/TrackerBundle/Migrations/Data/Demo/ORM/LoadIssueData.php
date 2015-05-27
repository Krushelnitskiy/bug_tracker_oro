<?php

namespace Oro\Bundle\TrackerBundle\Migrations\Data\Demo\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Oro\Bundle\TrackerBundle\Entity\Issue;
use Oro\Bundle\TrackerBundle\Entity\Type;

class LoadIssueData extends AbstractFixture implements ContainerAwareInterface
{
    protected $issues = array(
        array(
            'code' => 'test-1',
            'summary' => 'Issue 1 summary',
            'description' => 'Issue 1 description',
            'type'=> Type::TYPE_STORY
        ),
        array(
            'code' => 'test-2',
            'summary' => 'Issue 2 summary',
            'description' => 'Issue 2 description',
            'type'=> Type::TYPE_SUB_TASK
        ),
        array(
            'code' => 'test-3',
            'summary' => 'Issue 3 summary',
            'description' => 'Issue 3 description',
            'type'=> Type::TYPE_SUB_TASK
        ),
        array(
            'code' => 'test-4',
            'summary' => 'Issue 4 summary' ,
            'description' => 'Issue 4 description',
            'type'=> Type::TYPE_SUB_TASK
        )
    );

    protected $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $objectManager)
    {

        $organization = $objectManager->getRepository('OroOrganizationBundle:Organization')->getFirst();

        $users = $objectManager->getRepository('OroUserBundle:User')->findAll();
        $priorities = $objectManager->getRepository('OroTrackerBundle:Priority')->findAll();

        $usersCount = count($users);
        $priorityCount = count($priorities);

        $parent = null;
        foreach ($this->issues as $issueDemo) {
            /**
             * @var $type Type
             */
            $type = $objectManager->getRepository('OroTrackerBundle:Type')->findOneBy(['name'=> $issueDemo['type']]);

            $issue = new Issue();
            $issue->setCode($issueDemo['code']);
            $issue->setSummary($issueDemo['summary']);
            $issue->setDescription($issueDemo['description']);
            $issue->setAssignee($users[rand(0, $usersCount - 1)]);
            $issue->setOwner($users[rand(0, $usersCount - 1)]);
            $issue->setType($type);
            $issue->setPriority($priorities[rand(0, $priorityCount - 1)]);
            $issue->setOrganization($organization);

            if ($type->getName() === Type::TYPE_STORY) {
                $parent = $issue;
            }

            if ($type->getName() === Type::TYPE_SUB_TASK) {
                $issue->setParent($parent);
            }


            $objectManager->persist($issue);

        }

        $objectManager->flush();
    }
}
