<?php

namespace Oro\Bundle\TrackerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Oro\Bundle\TrackerBundle\Model\ExtendIssue;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\WorkflowBundle\Entity\WorkflowItem;
use Oro\Bundle\WorkflowBundle\Entity\WorkflowStep;
use Oro\Bundle\TagBundle\Entity\Taggable;
use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\TrackerBundle\Entity\Type;

/**
 * Class Issue
 * @package Oro\Bundle\TrackerBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Oro\Bundle\TrackerBundle\Entity\Repository\IssueRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *      name="oro_tracker_issue",
 * )
 * @Config(
 *      defaultValues={
 *           "workflow"={
 *              "active_workflow"="issue_flow"
 *          },
 *          "security"={
 *              "type"="ACL"
 *          },
 *          "ownership"={
 *              "owner_type"="USER",
 *              "owner_field_name"="owner",
 *              "owner_column_name"="owner_id",
 *              "organization_field_name"="organization",
 *              "organization_column_name"="organization_id"
 *          },
 *      }
 * )
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @UniqueEntity(
 *      fields={"code"},
 *      message="oro.tracker.issue.code.unique"
 * )
 */
class Issue extends ExtendIssue implements Taggable
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "order"=0
     *      }
     *  }
     * )
     */
    protected $id;

    /**
     * @var string $summary
     *
     * @ORM\Column(type="string", nullable=false)
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "order"=10,
     *          "header"="Summary"
     *      }
     *  }
     * )
     */
    protected $summary;

    /**
     * @var string $code
     *
     * @ORM\Column(name="`code`", type="string", length=50, unique=true)
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "order"=20,
     *          "header"="Code"
     *      }
     *  }
     * )
     */
    protected $code;

    /**
     * @var string $description
     *
     * @ORM\Column(type="string", nullable=true)
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "order"=30,
     *          "header"="Description"
     *      }
     *  }
     * )
     */
    protected $description;

    /**
     * @var Organization $organization
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\Organization")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "order"=40,
     *          "header"="Organization"
     *      }
     *  }
     * )
     */
    protected $organization;

    /**
     * @var Type $type
     *
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "header"="Type",
     *          "order"=50
     *      }
     *  }
     * )
     **/
    protected $type;

    /**
     * @var Priority $priority
     *
     * @ORM\ManyToOne(targetEntity="Priority")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id")
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "header"="Priority",
     *          "order"=60
     *      }
     *  }
     * )
     **/
    protected $priority;

    /**
     * @var Resolution $resolution
     * @ORM\ManyToOne(targetEntity="Resolution")
     * @ORM\JoinColumn(name="resolution_id", referencedColumnName="id")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "order"=70
     *          }
     *      }
     * )
     **/
    protected $resolution;

    /**
     * @var User $assignee
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="assignee_id", referencedColumnName="id")
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "order"=80
     *      }
     *  }
     * )
     **/
    protected $assignee;

    /**
     * @var User $owner
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "order"=90
     *      }
     *  }
     * )
     **/
    protected $owner;

    /**
     * @var ArrayCollection $collaborators
     *
     * @ORM\ManyToMany(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinTable(
     *      name="oro_tracker_issue_collaborator",
     *      joinColumns={
     *          @ORM\JoinColumn(name="issue_id", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *      }
     * )
     * @ConfigField(
     *  defaultValues={
     *      "dataaudit"={
     *          "auditable"=true
     *       },
     *      "importexport"={
     *          "excluded"=true
     *      }
     *  }
     * )
     */
    protected $collaborators;

    /**
     * @var Issue[] $children
     *
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="parent")
     **/
    protected $children;

    /**
     * @var Issue $parent
     * @ORM\ManyToOne(targetEntity="Issue", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    protected $parent;

    /**
     * @ORM\ManyToMany(targetEntity="Issue", mappedBy="myRelated", cascade="PERSIST")
     **/
    protected $relatedWithMe;

    /**
     * @ORM\ManyToMany(targetEntity="Issue", inversedBy="relatedWithMe", cascade="PERSIST")
     * @ORM\JoinTable(name="oro_tracker_issue_related",
     *      joinColumns={@ORM\JoinColumn(name="issue_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="related_issue_id", referencedColumnName="id")}
     *      )
     **/
    protected $myRelated;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "order"=100
     *      }
     *  }
     * )
     **/
    protected $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "order"=110
     *      }
     *  }
     * )
     **/
    protected $updatedAt;

    /**
     * @var WorkflowItem $workflowItem
     *
     * @ORM\OneToOne(targetEntity="Oro\Bundle\WorkflowBundle\Entity\WorkflowItem")
     * @ORM\JoinColumn(name="workflow_item_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "header"="Item",
     *          "excluded"=true
     *      }
     *  }
     * )
     */
    protected $workflowItem;

    /**
     * @var WorkflowStep $workflowStep
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\WorkflowBundle\Entity\WorkflowStep")
     * @ORM\JoinColumn(name="workflow_step_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "header"="Status",
     *          "full"=false
     *      }
     *  }
     * )
     */
    protected $workflowStep;

    /**
     * @var ArrayCollection $tags
     *
     * @ConfigField(
     *      defaultValues={
     *          "merge"={
     *              "display"=true
     *          },
     *          "importexport"={
     *              "header"="Tags"
     *          }
     *      }
     * )
     */
    protected $tags;

    public function __construct()
    {
        parent::__construct();

        $this->collaborators = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->relatedWithMe = new ArrayCollection();
        $this->myRelated = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return Issue
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Issue
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Issue
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Issue
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Issue
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set type
     *
     * @param Type $type
     *
     * @return Issue
     */
    public function setType(Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set priority
     *
     * @param Priority $priority
     *
     * @return Issue
     */
    public function setPriority(Priority $priority = null)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set resolution
     *
     * @param Resolution $resolution
     *
     * @return Issue
     */
    public function setResolution(Resolution $resolution = null)
    {
        $this->resolution = $resolution;

        return $this;
    }

    /**
     * Get resolution
     *
     * @return Resolution
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * Set assignee
     *
     * @param User $assignee
     * @return Issue
     */
    public function setAssignee(User $assignee = null)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * Get assignee
     *
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

     /**
     * Add collaborators
     *
     * @param User $collaborators
     * @return Issue
     */
    public function addCollaborator(User $collaborators)
    {
        if (!$this->getCollaborators()->contains($collaborators)) {
            $this->collaborators->add($collaborators);
        }

        return $this;
    }

    /**
     * Remove collaborators
     *
     * @param User $collaborators
     */
    public function removeCollaborator(User $collaborators)
    {
        $this->collaborators->removeElement($collaborators);
    }

    /**
     * Get collaborators
     *
     * @return Collection
     */
    public function getCollaborators()
    {
        return $this->collaborators;
    }

    /**
     * Add children
     *
     * @param Issue $children
     * @return Issue
     */
    public function addChild(Issue $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param Issue $children
     */
    public function removeChild(Issue $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param Issue $parent
     * @return Issue
     */
    public function setParent(Issue $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Issue
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set workflowItem
     *
     * @param WorkflowItem $workflowItem
     *
     * @return Issue
     */
    public function setWorkflowItem(WorkflowItem $workflowItem = null)
    {
        $this->workflowItem = $workflowItem;

        return $this;
    }

    /**
     * Get workflowItem
     *
     * @return WorkflowItem
     */
    public function getWorkflowItem()
    {
        return $this->workflowItem;
    }

    /**
     * Set workflowStep
     *
     * @param WorkflowStep $workflowStep
     *
     * @return Issue
     */
    public function setWorkflowStep(WorkflowStep $workflowStep = null)
    {
        $this->workflowStep = $workflowStep;

        return $this;
    }

    /**
     * Get workflowStep
     *
     * @return WorkflowStep
     */
    public function getWorkflowStep()
    {
        return $this->workflowStep;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param $user User
     *
     * @return Issue
     */
    public function setOwner($user)
    {
        $this->owner = $user;

        return $this;
    }

    /**
     * Set organization
     *
     * @param Organization $organization
     *
     * @return Issue
     */
    public function setOrganization(Organization $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @ORM\PrePersist
     */
    public function doStuffOnPrePersist()
    {
        $this->createdAt = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * {@inheritdoc}
     */
    public function getTags()
    {
        $this->tags = $this->tags ?: new ArrayCollection();

        return $this->tags;
    }

    /**
     * {@inheritdoc}
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTaggableId()
    {
        return $this->getId();
    }

    /**
     * Add relatedWithMe
     *
     * @param Issue $issue
     *
     * @return Issue
     */
    public function addRelatedWithMe(Issue $issue)
    {
        $this->relatedWithMe[] = $issue;

        return $this;
    }

    /**
     * Remove relatedWithMe
     *
     * @param Issue $issue
     */
    public function removeRelatedWithMe(Issue $issue)
    {
        $this->relatedWithMe->removeElement($issue);
    }

    /**
     * Get relatedWithMe
     *
     * @return Collection
     */
    public function getRelatedWithMe()
    {
        return $this->relatedWithMe;
    }

    /**
     * Add myRelated
     *
     * @param Issue $issue
     *
     * @return Issue
     */
    public function addMyRelated(Issue $issue)
    {
        $this->myRelated[] = $issue;

        return $this;
    }

    /**
     * Remove myRelated
     *
     * @param Issue $issue
     */
    public function removeMyRelated(Issue $issue)
    {
        $this->myRelated->removeElement($issue);
    }

    /**
     * Get myRelated
     *
     * @return ArrayCollection
     */
    public function getMyRelated()
    {
        return $this->myRelated;
    }
}
