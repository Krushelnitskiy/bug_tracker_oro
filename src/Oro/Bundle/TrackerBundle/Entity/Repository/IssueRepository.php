<?php

namespace Oro\Bundle\TrackerBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class IssueRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllGroupedBySteps()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder('issue')
            ->select('count(issue.id) issue_count, workflowStep.label')
            ->from('OroTrackerBundle:Issue', 'issue')
            ->leftJoin('OroWorkflowBundle:WorkflowStep', 'workflowStep', 'WITH', 'issue.workflowStep = workflowStep')
            ->groupBy('workflowStep.id');

        return $queryBuilder;
    }
}
