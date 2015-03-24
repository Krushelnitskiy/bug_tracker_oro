<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.03.15
 * Time: 12:38
 */

namespace Oro\Bundle\TrackerBundle\Entity;

use Doctrine\ORM\EntityRepository;

class IssueRepository extends  EntityRepository
{
    public function findAllGroupedBySteps()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder('issue')
            ->select('count(issue.id) issue_count, workflowStep.label')
            ->from('OroTrackerBundle:Issue', 'issue')
            ->leftJoin('OroWorkflowBundle:WorkflowStep', 'workflowStep', 'WITH', 'issue.workflowStep = workflowStep')
            ->groupBy('workflowStep.id');

        return $queryBuilder->getQuery()->getResult();
    }
}
