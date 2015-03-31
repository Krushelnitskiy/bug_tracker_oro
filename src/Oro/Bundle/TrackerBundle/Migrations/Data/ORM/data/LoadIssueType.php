<?php

namespace Oro\Bundle\TrackerBundle\Migrations\Data\ORM;

use Oro\Bundle\TranslationBundle\DataFixtures\AbstractTranslatableEntityFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\TrackerBundle\Entity\Type;

class LoadIssueType extends AbstractTranslatableEntityFixture
{
    const ISSUE_TYPE_PREFIX = 'issue_type';

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
     * Load entities to DB
     *
     * @param ObjectManager $manager
     */
    protected function loadEntities(ObjectManager $manager)
    {
        $typeRepository = $manager->getRepository('OroTrackerBundle:Type');

        $translationLocales = $this->getTranslationLocales();

        foreach ($translationLocales as $locale) {
            foreach ($this->data as $type) {
                /** @var Type $issueType */
                $issueType = $typeRepository->findOneBy(array('name' => $type['name']));

                if (!$issueType) {
                    $issueType = new Type();
                    $issueType->setOrder($type['order']);
                    $issueType->setName($type['name']);
                }

                // set locale and label
                $priorityLabel = $this->translate($type['name'], static::ISSUE_TYPE_PREFIX, $locale);
                $issueType->setLocale($locale)
                    ->setLabel($priorityLabel);

                // save
                $manager->persist($issueType);
            }
        }
        $manager->flush();
    }
}
