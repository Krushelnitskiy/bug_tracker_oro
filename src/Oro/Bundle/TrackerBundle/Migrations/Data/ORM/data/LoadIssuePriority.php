<?php

namespace Oro\Bundle\TrackerBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\TrackerBundle\Entity\Priority;

class LoadIssuePriority extends AbstractFixture
{
    /**
     * @var array
     */
    protected $data = array(
        array(
            'label' => Priority::PRIORITY_BLOCKER,
            'name' =>  Priority::PRIORITY_BLOCKER,
            'order' => 1
        ),
        array(
            'label' => Priority::PRIORITY_CRITICAL,
            'name' => Priority::PRIORITY_CRITICAL,
            'order' => 2
        ),
        array(
            'label' => Priority::PRIORITY_MAJOR,
            'name' => Priority::PRIORITY_MAJOR,
            'order' => 3
        ),
        array(
            'label' => Priority::PRIORITY_MINOR,
            'name' => Priority::PRIORITY_MINOR,
            'order' => 4
        ),
        array(
            'label' => Priority::PRIORITY_TRIVIAL,
            'name' => Priority::PRIORITY_TRIVIAL,
            'order' => 5
        )
    );

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $priority) {
            if (!$this->isPriorityExist($manager, $priority['name'])) {
                $entity = new Priority();
                $entity->setName($priority['name']);
                $entity->setLabel($priority['label']);
                $entity->setOrder($priority['order']);
                $manager->persist($entity);
            }
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param string $priorityType
     * @return bool
     */
    private function isPriorityExist(ObjectManager $manager, $priorityName)
    {
        return count($manager->getRepository('OroTrackerBundle:Priority')->findByName($priorityName)) > 0;
    }
}
