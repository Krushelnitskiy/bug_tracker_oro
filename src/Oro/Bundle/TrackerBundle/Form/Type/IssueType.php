<?php

namespace Oro\Bundle\TrackerBundle\Form\Type;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssueType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
                    'required' => false,
                    'label' => 'oro.tracker.issue.reporter.label'
                ]
            )
            ->add(
                'assignee',
                'oro_user_select',
                [
                    'required' => false,
                    'label' => 'oro.tracker.issue.assignee.label'
                ]
            )
            ->add(
                'type',
                'translatable_entity',
                [
                    'label' => 'oro.tracker.issue.type.label',
                    'class' => 'Oro\Bundle\TrackerBundle\Entity\Type',
                    'required' => true,
                    'query_builder' => function (EntityRepository $repository) {
                        return $repository->createQueryBuilder('type')->orderBy('type.order');
                    }
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
        ;
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
