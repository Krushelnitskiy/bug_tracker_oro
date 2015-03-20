<?php

namespace Oro\Bundle\TrackerBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\TrackerBundle\Entity\Type;

class LoadIssueType extends AbstractFixture
{
    /**
     * @var array
     */
    protected $data = array(
        array(
            'label' => Type::TYPE_BUG,
            'name' =>  Type::TYPE_BUG,
            'order' => 1
        ),
        array(
            'label' => Type::TYPE_STORY,
            'name' =>  Type::TYPE_STORY,
            'order' => 2
        ),
        array(
            'label' => Type::TYPE_SUB_TASK,
            'name' => Type::TYPE_SUB_TASK,
            'order' => 3
        ),
        array(
            'label' => Type::TYPE_TASK,
            'name' => Type::TYPE_TASK,
            'order' => 4
        )
    );

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $type) {
            if (!$this->isPriorityExist($manager, $type['name'])) {
                $entity = new Type();
                $entity->setName($type['name']);
                $entity->setLabel($type['label']);
                $entity->setOrder($type['order']);
                $manager->persist($entity);
            }
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param string $type
     * @return bool
     */
    private function isPriorityExist(ObjectManager $manager, $typeName)
    {
        return count($manager->getRepository('OroTrackerBundle:Type')->findByName($typeName)) > 0;
    }
}
