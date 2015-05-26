<?php

namespace Oro\Bundle\TrackerBundle\Form\Type;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Oro\Bundle\TrackerBundle\Entity\Issue;
use Oro\Bundle\TrackerBundle\Entity\Type;

use Symfony\Component\Security\Core\SecurityContextInterface;

class IssueType extends AbstractType
{
    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->securityContext->getToken()->getUser();

        $builder
            ->add(
                'code',
                'text',
                [
                    'required' => true,
                    'label' => 'oro.tracker.issue.code.label'
                ]
            )
            ->add(
                'summary',
                'text',
                [
                    'required' => true,
                    'label' => 'oro.tracker.issue.summary.label'
                ]
            )
            ->add(
                'description',
                'textarea',
                [
                    'required' => false,
                    'label' => 'oro.tracker.issue.description.label'
                ]
            )
            ->add(
                'reporter',
                'oro_user_select',
                [
                    'required' => true,
                    'label' => 'oro.tracker.issue.reporter.label',
                    'data' => $user
                ]
            )
            ->add(
                'owner',
                'oro_user_select',
                [
                    'required' => true,
                    'label' => 'oro.tracker.issue.owner.label'
                ]
            )
            ->add(
                'priority',
                'translatable_entity',
                [
                    'label' => 'oro.tracker.issue.priority.label',
                    'class' => 'Oro\Bundle\TrackerBundle\Entity\Priority',
                    'required' => true,
                    'query_builder' => function (EntityRepository $repository) {
                        return $repository->createQueryBuilder('priority')->orderBy('priority.order');
                    }
                ]
            )
            ->add(
                'tags',
                'oro_tag_select',
                array(
                    'label' => 'oro.tag.entity_plural_label'
                )
            )

        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $this->addTypeField());
        $builder->addEventListener(FormEvents::PRE_SET_DATA, $this->addRelatedIssueField());
    }

    protected function addRelatedIssueField()
    {
        return function (FormEvent $event) {
            $issue = $event->getData();
            $builder = $event->getForm();


                $builder->add(
                    'myRelated',
                    'entity',
                    array(
                        'class' => 'Oro\Bundle\TrackerBundle\Entity\Issue',
                        'multiple' => true,
                        'required'=> false,
                        'query_builder' =>
                            function (EntityRepository $entityRepository) use ($issue) {
                                $issueId = 0;
                                if ($issue instanceof Issue) {
                                    $issueId = $issue->getId() ? $issue->getId() : 0;
                                }

                                return $entityRepository
                                    ->createQueryBuilder('issue')
                                    ->where('issue.id != :issue_id')
                                    ->setParameter('issue_id', $issueId);
                            },
                        'property' => 'code',
                        'label' => 'oro.tracker.issue.related.label'
                    )
                );

        };
    }

    /**
     * @return callable
     */
    protected function addTypeField()
    {
        return function (FormEvent $event) {
            $issue = $event->getData();
            $builder = $event->getForm();

            if ($this->canAddFiledType($issue)) {
                $builder->add(
                    'type',
                    'entity',
                    array(
                        'class' => 'Oro\Bundle\TrackerBundle\Entity\Type',
                        'query_builder' =>
                            function (EntityRepository $entityRepository) {
                                return $entityRepository
                                    ->createQueryBuilder('type')
                                    ->where('type.name != :type_name')
                                    ->setParameter('type_name', Type::TYPE_SUB_TASK)
                                    ->orderBy('type.order', 'DESC');
                            },
                        'property' => 'label',
                        'label' => 'oro.tracker.issue.type.label'
                    )
                );
            }
        };
    }

    protected function canAddFiledType($issue)
    {
        $isIssue = $issue instanceof Issue;

        if ($isIssue) {
            /**s
             * @var $issue Issue
             */
            $hasTypeSubTask = (!$issue->getType() || $issue->getType()->getName() !== Type::TYPE_SUB_TASK);
            return $isIssue && $hasTypeSubTask;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Oro\Bundle\TrackerBundle\Entity\Issue',
             'intention' => 'issue',
             'cascade_validation' => true
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'orotracker_issue';
    }
}
