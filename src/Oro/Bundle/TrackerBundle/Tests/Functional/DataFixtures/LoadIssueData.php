<?php

namespace Oro\Bundle\TrackerBundle\Tests\Functional\DataFixtures;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\TrackerBundle\Entity\Type;
use Oro\Bundle\TrackerBundle\Entity\Issue;

class LoadIssueData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $issuesData = array(
        array(
            'summary'       => 'Issue #1',
            'description'   => 'Issue #1: Description',
            'reportedAt'    => '2014-01-01 13:00:00',
            'reporter'      => 'orocrm_case_contact',
            'owner'         => 'orocrm_case_contact',
            'code' => '1',
            'workflow_step_id' => 1
        ),
        array(
            'summary'       => 'Issue #2',
            'description'   => 'Issue #2: Description',
            'reportedAt'    => '2014-01-01 13:00:00',
            'reporter'      => 'orocrm_case_contact',
            'owner'         => 'orocrm_case_contact',
            'code' => '2',
            'workflow_step_id' => 2
        )
    );

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $adminUser = $manager->getRepository('OroUserBundle:User')->findOneByUsername('admin');
        $typeStory = $manager->getRepository('OroTrackerBundle:Type')->findOneBy(['name' => Type::TYPE_STORY]);

        foreach ($this->issuesData as $caseData) {
            $issue = new Issue();
            $issue->setSummary($caseData['summary'])
                ->setDescription($caseData['description'])
                ->setCode($caseData['summary'])
                ->setOwner($adminUser)
                ->setType($typeStory)
                ->setReporter($adminUser);

            $manager->persist($issue);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
