<?php

namespace Oro\Bundle\TrackerBundle\Tests\Functional\Repository;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;
use Oro\Bundle\TrackerBundle\Entity\Issue;

/**
 * Class ProductRepositoryFunctionalTest
 * @package Oro\TrackerBundle\Tests\Functional\Repository
 * @dbIsolation
 * @dbReindex
 */
class ProductRepositoryFunctionalTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->initClient([], $this->generateBasicAuthHeader());
        $this->loadFixtures(['Oro\Bundle\TrackerBundle\Tests\Functional\DataFixtures\LoadIssueData']);
    }

    protected function postFixtureLoad()
    {
        $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
        /**
         * @var $issue Issue
         */
        $issue = $this->getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository('OroTrackerBundle:Issue')
            ->findOneBySummary('Issue #2');
        $workflow = $this->em->getRepository('OroWorkflowBundle:WorkflowStep')->findOneByName('in_progress');
        $issue->setWorkflowStep($workflow);
        $this->em->persist($issue);
        $this->em->flush();
    }

    public function testSearchByCategoryName()
    {
        $issues = $this->em
            ->getRepository('OroTrackerBundle:Issue')
            ->findAllGroupedBySteps();

        $this->assertEquals(
            'SELECT count(issue.id) issue_count, workflowStep.label FROM OroTrackerBundle:Issue issue '.
            'LEFT JOIN OroWorkflowBundle:WorkflowStep workflowStep WITH issue.workflowStep = workflowStep '.
            'GROUP BY workflowStep.id',
            $issues->getDQL()
        );

        $this->assertCount(2, $issues->getQuery()->getResult());
    }
}
