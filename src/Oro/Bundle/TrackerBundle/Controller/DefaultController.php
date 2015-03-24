<?php

namespace Oro\Bundle\TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Oro\Bundle\TrackerBundle\Entity\Issue;
use Oro\Bundle\TrackerBundle\Entity\Type;
use Oro\Bundle\TrackerBundle\Form\Type\IssueType;

/**
 * Class DefaultController
 * @package Oro\Bundle\TrackerBundle\Controller
 * @Route("/tracker")
 */
class DefaultController extends Controller
{
    /**
     * @Route(
     *      "/",
     *      name="orotracker_issue_index",
     * )
     * @Template
     */
    public function indexAction()
    {
        return [
            'entity_class' => $this->container->getParameter('orotracker_issue.entity.class')
        ];
    }

    /**
     * @Route("/view/{id}", name="orotracker_issue_view", requirements={"id"="\d+"})
     * @Template
     */
    public function viewAction(Issue $issue)
    {
        return array('entity'=>$issue);
    }

    /**
     * @Route("/create", name="orotracker_issue_create")
     * @Template("OroTrackerBundle:Default:update.html.twig")
     */
    public function createAction()
    {
        $issue = new Issue();

//        $defaultPriority = $this->getRepository('OroCRMTaskBundle:TaskPriority')->find('normal');
//        if ($defaultPriority) {
//            $issue->setTaskPriority($defaultPriority);
//        }

        $issue->setCreatedAt(new \DateTime());
        $issue->setUpdatedAt(new \DateTime());

        $formAction = $this->get('oro_entity.routing_helper')
            ->generateUrlByRequest('orotracker_issue_create', $this->getRequest());

        return $this->update($issue, $formAction);
    }

    /**
     * @param Issue $issue
     * @param string $formAction
     * @return array
     */
    protected function update(Issue $issue, $formAction)
    {
        $saved = false;

        if ($this->get('orotracker_issue.form.handler.issue')->process($issue)) {
            if (!$this->getRequest()->get('_widgetContainer')) {
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('oro.tracker.issue.saved_message')
                );

                return $this->get('oro_ui.router')->redirectAfterSave(
                    array(
                        'route' => 'orotracker_issue_update',
                        'parameters' => array('id' => $issue->getId())
                    ),
                    array(
                        'route' => 'orotracker_issue_view',
                        'parameters' => array('id' => $issue->getId())
                    )
                );
            }
            $saved = true;
        }

        return array(
            'entity'     => $issue,
            'saved'      => $saved,
            'form'       => $this->get('orotracker_issue.form.handler.issue')->getForm()->createView(),
            'formAction' => $formAction
        );
    }

    /**
     * @Route("/update/{id}", name="orotracker_issue_update", requirements={"id"="\d+"})
     * @Template
     */
    public function updateAction(Issue $task)
    {
        $formAction = $this->get('router')->generate('orotracker_issue_update', ['id' => $task->getId()]);

        return $this->update($task, $formAction);
    }

    /**
     * @Route("/{id}/sub-task/create", name="orotracker_issue_add_child")
     * @Template("OroTrackerBundle:Default:update.html.twig")
     */
    public function createSubTaskAction(Issue $issue)
    {
//        var_dump($task);exit;

        $issueSubTask = new Issue();

        $typeSubTask = $this->getDoctrine()->getRepository('OroTrackerBundle:Type')->findOneBy(['name'=>Type::TYPE_SUB_TASK]);

        $issueSubTask->setCreatedAt(new \DateTime());
        $issueSubTask->setUpdatedAt(new \DateTime());
        $issueSubTask->setParent($issue);
        $issueSubTask->setType($typeSubTask);

        $formAction = $this->get('oro_entity.routing_helper')
            ->generateUrlByRequest('orotracker_issue_add_child', $this->getRequest(), ['id'=>$issue->getId()]);

        return $this->update($issueSubTask, $formAction);
    }

    /**
     * @Route(
     *      "/by_status/chart/{widget}",
     *      name="orotracker_issue_chart",
     *      requirements={
    *           "widget"="[\w-]+"
     *      }
     * )
     *
     * @Template("OroTrackerBundle:Dashboard:chart.html.twig")
     * @return array $widgetAttr
     */
    public function chartAction($widget)
    {
        $data = $this->getDoctrine()
            ->getRepository('OroTrackerBundle:Issue')
            ->findAllGroupedBySteps();

        $widgetAttr = $this->get('oro_dashboard.widget_configs')->getWidgetAttributesForTwig($widget);
        $widgetAttr['chartView'] = $this->get('oro_chart.view_builder')
            ->setArrayData($data)
            ->setOptions(
                array(
                    'name' => 'pie_chart',
                    'data_schema' => array(
                        'label' => array('field_name' => 'label'),
                        'value' => array(
                            'field_name' => 'issue_count'
                        )
                    )
                )
            )
            ->getView();

        return $widgetAttr;
    }

//    /**
//     * @return IssueType
//     */
//    protected function getFormType()
//    {
//        return $this->get('orotracker_issue.form.handler.issue')->getForm();
//    }
}
