<?php

namespace Acme\StoreBundle\Tests\Entity;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

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
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }

    public function testSearchByCategoryName()
    {
        $issues = $this->em
            ->getRepository('OroTrackerBundle:Issue')
            ->findAllGroupedBySteps();
        ;

        $this->assertEquals(
            'SELECT count(issue.id) issue_count, workflowStep.label FROM OroTrackerBundle:Issue issue '.
            'LEFT JOIN OroWorkflowBundle:WorkflowStep workflowStep WITH issue.workflowStep = workflowStep '.
            'GROUP BY workflowStep.id',
            $issues->getDQL()
        );
    }
}
