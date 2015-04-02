<?php

namespace Oro\Bundle\TrackerBundle\ImportExport\TemplateFixture;

use Oro\Bundle\ImportExportBundle\TemplateFixture\AbstractTemplateRepository;
use Oro\Bundle\ImportExportBundle\TemplateFixture\TemplateFixtureInterface;
use Oro\Bundle\TrackerBundle\Entity\Issue;
use Oro\Bundle\TrackerBundle\Entity\Priority;
use Oro\Bundle\TrackerBundle\Entity\Resolution;
use Oro\Bundle\TrackerBundle\Entity\Type;

class IssueFixture extends AbstractTemplateRepository implements TemplateFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return 'Oro\Bundle\TrackerBundle\Entity\Issue';
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->getEntityData('Issue Export Import');
    }

    /**
     * {@inheritdoc}
     */
    protected function createEntity($key)
    {
        return new Issue();
    }

    /**
     * @param string $key
     * @param Issue $entity
     */
    public function fillEntityData($key, $entity)
    {
        $userRepo         = $this->templateManager->getEntityRepository('Oro\Bundle\UserBundle\Entity\User');
        $user = $userRepo->getEntity('John Doo');

        $entityRepository = 'Oro\Bundle\OrganizationBundle\Entity\Organization';
        $organizationRepo = $this->templateManager->getEntityRepository($entityRepository);

        $priority = new Priority();
        $priority->setName(Priority::PRIORITY_BLOCKER);
        $priority->setLabel(Priority::PRIORITY_BLOCKER);
        $priority->setOrder(1);

        $type = new Type();
        $type->setName(Type::TYPE_STORY);
        $type->setLabel(Type::TYPE_STORY);
        $type->setOrder();;

        $resolution = new Resolution();

        switch ($key) {
            case 'Issue Export Import':
                $entity->setSummary('Issue Export Import');
                $entity->setCode('1');
                $entity->setOwner($user);
                $entity->setOrganization($organizationRepo->getEntity('default'));
                $entity->setDescription(('Issue Export Import description'));
                $entity->setCreatedAt(new \DateTime());
                $entity->setUpdatedAt(new \DateTime());
                $entity->setReporter($user);
                $entity->setResolution($resolution);
                $entity->setType($type);
                $entity->setPriority($priority);

                return;
        }

        parent::fillEntityData($key, $entity);
    }
}
