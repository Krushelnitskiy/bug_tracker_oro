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

class IssueType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
                    'required' => false,
                    'label' => 'oro.tracker.issue.reporter.label'
                ]
            )
            ->add(
                'owner',
                'oro_user_select',
                [
                    'required' => false,
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
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $this->addTypeField());
    }

    protected function addTypeField()
    {
        return function(FormEvent $event) {
            $issue = $event->getData();
            $builder = $event->getForm();

            if ($issue instanceof Issue && (!$issue->getType() || $issue->getType()->getName() !== Type::TYPE_SUB_TASK)) {
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

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Oro\Bundle\TrackerBundle\Entity\Issue',
             'intention' => 'isuse',
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
