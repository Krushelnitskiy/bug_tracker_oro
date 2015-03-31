<?php

namespace Oro\Bundle\TrackerBundle\Migrations\Data\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\TranslationBundle\DataFixtures\AbstractTranslatableEntityFixture;
use Oro\Bundle\TrackerBundle\Entity\Priority;

class LoadIssuePriority extends AbstractTranslatableEntityFixture
{
    const ISSUE_PRIORITY_PREFIX = 'issue_priority';

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
     * Load entities to DB
     *
     * @param ObjectManager $manager
     */
    protected function loadEntities(ObjectManager $manager)
    {
        $priorityRepository = $manager->getRepository('OroTrackerBundle:Priority');

        $translationLocales = $this->getTranslationLocales();

        foreach ($translationLocales as $locale) {
            foreach ($this->data as $priority) {
                /** @var Priority $issuePriority */
                $issuePriority = $priorityRepository->findOneBy(array('name' => $priority['name']));

                if (!$issuePriority) {
                    $issuePriority = new Priority();
                    $issuePriority->setOrder($priority['order']);
                    $issuePriority->setName($priority['name']);
                }

                // set locale and label
                $priorityLabel = $this->translate($priority['name'], static::ISSUE_PRIORITY_PREFIX, $locale);
                $issuePriority->setLocale($locale)
                    ->setLabel($priorityLabel);

                // save
                $manager->persist($issuePriority);
            }
        }
        $manager->flush();
    }
}
