<?php

namespace Oro\Bundle\TrackerBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\TrackerBundle\Entity\Resolution;

class LoadResolutionType extends AbstractFixture
{
    /**
     * @var array
     */
    protected $data = array(
        array(
            'label' => Resolution::RESOLUTION_DONE,
            'name' =>  Resolution::RESOLUTION_DONE,
            'order' => 1
        ),
        array(
            'label' => Resolution::RESOLUTION_FIXED,
            'name' =>  Resolution::RESOLUTION_FIXED,
            'order' => 2
        ),
        array(
            'label' => Resolution::RESOLUTION_WONT_FIX,
            'name' =>  Resolution::RESOLUTION_WONT_FIX,
            'order' => 3
        ),
        array(
            'label' => Resolution::RESOLUTION_WONT_DO,
            'name' =>  Resolution::RESOLUTION_WONT_DO,
            'order' => 4
        )
    );

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $resolution) {
            if (!$this->isPriorityExist($manager, $resolution['name'])) {
                $entity = new Resolution();
                $entity->setName($resolution['name']);
                $entity->setLabel($resolution['label']);
                $entity->setOrder($resolution['order']);
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
    private function isPriorityExist(ObjectManager $manager, $resolutionName)
    {
        return count($manager->getRepository('OroTrackerBundle:Resolution')->findByName($resolutionName)) > 0;
    }
}
