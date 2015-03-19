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
