<?php

namespace Oro\Bundle\TrackerBundle\Migrations\Data\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\TranslationBundle\DataFixtures\AbstractTranslatableEntityFixture;
use Oro\Bundle\TrackerBundle\Entity\Resolution;

class LoadResolutionType extends AbstractTranslatableEntityFixture
{
    const ISSUE_RESOLUTION_PREFIX = 'issue_resolution';
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
     * Load entities to DB
     *
     * @param ObjectManager $manager
     */
    protected function loadEntities(ObjectManager $manager)
    {
        $resolutionRepository = $manager->getRepository('OroTrackerBundle:Resolution');
        $translationLocales = $this->getTranslationLocales();

        foreach ($translationLocales as $locale) {
            foreach ($this->data as $resolution) {
                /** @var Resolution $issueType */
                $issueType = $resolutionRepository->findOneBy(array('name' => $resolution['name']));

                if (!$issueType) {
                    $issueType = new Resolution();
                    $issueType->setOrder($resolution['order']);
                    $issueType->setName($resolution['name']);
                }

                // set locale and label
                $priorityLabel = $this->translate($resolution['name'], static::ISSUE_RESOLUTION_PREFIX, $locale);
                $issueType->setLocale($locale)
                    ->setLabel($priorityLabel);

                // save
                $manager->persist($issueType);
            }
        }
        $manager->flush();
    }
}
