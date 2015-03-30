<?php

namespace Oro\Bundle\TrackerBundle\ImportExport\TemplateFixture;

use Oro\Bundle\ImportExportBundle\TemplateFixture\AbstractTemplateRepository;
use Oro\Bundle\ImportExportBundle\TemplateFixture\TemplateFixtureInterface;
use Proxies\__CG__\Oro\Bundle\TrackerBundle\Entity\Issue;

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
        return $this->getEntityData('Jerry Coleman');
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
     * @param Issue   $entity
     */
    public function fillEntityData($key, $entity)
    {
        $userRepo         = $this->templateManager->getEntityRepository('Oro\Bundle\UserBundle\Entity\User');

        $entityRepository = 'Oro\Bundle\OrganizationBundle\Entity\Organization';
        $organizationRepo = $this->templateManager->getEntityRepository($entityRepository);

        switch ($key) {
            case 'Jerry Coleman':
                $entity->setSummary('Oro Inc. Lead Name');
                $entity->setCode('1');
                $entity->setOwner($userRepo->getEntity('John Doo'));
                $entity->setOrganization($organizationRepo->getEntity('default'));
                $entity->setDescription(('B2b channel|b2b'));
                $entity->setCreatedAt(new \DateTime());
                $entity->setUpdatedAt(new \DateTime());
                $entity->setReporter($userRepo->getEntity('John Doo'));
                return;
        }

        parent::fillEntityData($key, $entity);
    }
}
