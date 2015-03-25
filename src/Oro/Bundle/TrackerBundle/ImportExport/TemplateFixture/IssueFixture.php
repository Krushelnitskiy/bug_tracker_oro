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
        $priorityRepo      = $this->templateManager->getEntityRepository('Oro\Bundle\TrackerBundle\Entity\Priority');
        $resolutionRepo      = $this->templateManager->getEntityRepository('Oro\Bundle\TrackerBundle\Entity\Resolution');
        $typeRepo      = $this->templateManager->getEntityRepository('Oro\Bundle\TrackerBundle\Entity\Type');
        $userRepo         = $this->templateManager->getEntityRepository('Oro\Bundle\UserBundle\Entity\User');

        $organizationRepo = $this->templateManager->getEntityRepository('Oro\Bundle\OrganizationBundle\Entity\Organization');

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
//                $entity->setPriority($priorityRepo->getEntity(''));
//
//                $entity->setContact($contactRepo->getEntity('Jerry Coleman'));
//                $entity->setAddress($addressRepo->getEntity('Jerry Coleman'));
//                $entity->setEmail('JerryAColeman@armyspy.com');
//                $entity->setNamePrefix('Mr.');
//                $entity->setFirstName('Jerry');
//                $entity->setLastName('Coleman');
//                $entity->setNameSuffix('Jr.');
//                $entity->setStatus(new LeadStatus('New'));
//                $entity->setJobTitle('Manager');
//                $entity->setPhoneNumber('585-255-1127');
//                $entity->setWebsite('http://orocrm.com');
//                $entity->setNumberOfEmployees(100);
//                $entity->setIndustry('Internet');

                return;
        }

        parent::fillEntityData($key, $entity);
    }
}
