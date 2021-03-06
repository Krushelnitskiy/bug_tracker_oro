<?php

namespace Oro\Bundle\TrackerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\ActivityBundle\Manager\ActivityManager;
use Oro\Bundle\EntityBundle\Tools\EntityRoutingHelper;
use Oro\Bundle\FormBundle\Utils\FormUtils;
use Oro\Bundle\TagBundle\Entity\TagManager;
use Oro\Bundle\TagBundle\Form\Handler\TagHandlerInterface;
use Oro\Bundle\TrackerBundle\Entity\Issue;
use Oro\Bundle\UserBundle\Entity\User;

class IssueHandler implements TagHandlerInterface
{
    /** @var FormInterface */
    protected $form;

    /** @var Request */
    protected $request;

    /** @var ObjectManager */
    protected $manager;

    /** @var  ActivityManager */
    protected $activityManager;

    /** @var EntityRoutingHelper */
    protected $entityRoutingHelper;

    /**
     * @var TagManager
     */
    protected $tagManager;

    /**
     * @param FormInterface       $form
     * @param Request             $request
     * @param ObjectManager       $manager
     * @param ActivityManager     $activityManager
     * @param EntityRoutingHelper $entityRoutingHelper
     */
    public function __construct(
        FormInterface $form,
        Request $request,
        ObjectManager $manager,
        ActivityManager $activityManager,
        EntityRoutingHelper $entityRoutingHelper
    ) {
        $this->form                = $form;
        $this->request             = $request;
        $this->manager             = $manager;
        $this->activityManager     = $activityManager;
        $this->entityRoutingHelper = $entityRoutingHelper;
    }

    /**
     * Process form
     *
     * @param  Issue $entity
     *
     * @return bool  True on successful processing, false otherwise
     */
    public function process(Issue $entity)
    {
        $action            = $this->entityRoutingHelper->getAction($this->request);
        $targetEntityClass = $this->entityRoutingHelper->getEntityClassName($this->request);
        $targetEntityId    = $this->entityRoutingHelper->getEntityId($this->request);

        if ($targetEntityClass
            && !$entity->getId()
            && $this->request->getMethod() === 'GET'
            && $action === 'assign'
            && is_a($targetEntityClass, 'Oro\Bundle\UserBundle\Entity\User', true)
        ) {
            $user = $this->entityRoutingHelper->getEntity($targetEntityClass, $targetEntityId);
            if ($user instanceof User) {
                $entity->setOwner($user);
            }
            FormUtils::replaceField($this->form, 'owner', ['read_only' => true]);
        }

        $this->form->setData($entity);

        if (in_array($this->request->getMethod(), array('POST', 'PUT'))) {
            $this->form->submit($this->request);

            if ($this->form->isValid()) {
                if ($targetEntityClass && $action === 'activity') {
                    $this->activityManager->addActivityTarget(
                        $entity,
                        $this->entityRoutingHelper->getEntityReference($targetEntityClass, $targetEntityId)
                    );
                }
                $this->onSuccess($entity);

                return true;
            }
        }

        return false;
    }

    /**
     * "Success" form handler
     *
     * @param Issue $entity
     */
    protected function onSuccess(Issue $entity)
    {
        $this->manager->persist($entity);
        $this->manager->flush();

        if ($this->tagManager) {
            $this->tagManager->saveTagging($entity);
        }
    }

    /**
     * Get form, that build into handler, via handler service
     *
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * {@inheritdoc}
     */
    public function setTagManager(TagManager $tagManager)
    {
        $this->tagManager = $tagManager;
    }
}
