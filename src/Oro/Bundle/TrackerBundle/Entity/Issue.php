<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.03.15
 * Time: 14:02
 */


namespace Oro\Bundle\TrackerBundle\Entity;

use Oro\Bundle\TrackerBundle\Model\ExtendIssue;
use Doctrine\Common\Collections\ArrayCollection;
use Oro\Bundle\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\WorkflowBundle\Entity\WorkflowItem;
use Oro\Bundle\WorkflowBundle\Entity\WorkflowStep;

/**
 * Class Issue
 * @package Oro\Bundle\TrackerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(
 *      name="oro_tracker_issue",
 * )
 * @Config(
 *      defaultValues={
 *          "workflow"={
 *              "active_workflow"="task_flow"
 *          },
 *           "workflow"={
 *              "active_workflow"="issue_flow"
 *          },
 *      }
 * )
 */
class Issue extends ExtendIssue
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $summary;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $code;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;


    /**
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     **/
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="Priority")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id")
     **/
    protected $priority;


//    /**
//     * @ORM\ManyToOne(targetEntity="Resolution")
//     * @ORM\JoinColumn(name="resolution_id", referencedColumnName="id")
//     **/
//    protected $resolution;
//
    /**
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="reporter_id", referencedColumnName="id")
     **/
    protected $reporter;

    /**
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="assignee_id", referencedColumnName="id")
     **/
    protected $assignee;

//    /**
//     * @ORM\ManyToMany(targetEntity="\Tracker\UserBundle\Entity\User", inversedBy="issue")
//     * @ORM\JoinTable(name="issue_collaborator")
//     **/
//
//    /**
//     * @var User
//     *
//     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User" inversedBy="issue")
//     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="SET NULL")
//     * @ConfigField(
//     *      defaultValues={
//     *          "dataaudit"={
//     *              "auditable"=true
//     *          }
//     *      }
//     * )
//     */
//    protected $collaborators;


    /**
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="parent")
     **/
    protected $children;

    /**
     * @var Issue
     * @ORM\ManyToOne(targetEntity="Issue", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    protected $parent;


    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     **/
    protected $created;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     **/
    protected $updated;


    /**
     * @var WorkflowItem
     *
     * @ORM\OneToOne(targetEntity="Oro\Bundle\WorkflowBundle\Entity\WorkflowItem")
     * @ORM\JoinColumn(name="workflow_item_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $workflowItem;

    /**
     * @var WorkflowStep
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\WorkflowBundle\Entity\WorkflowStep")
     * @ORM\JoinColumn(name="workflow_step_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $workflowStep;

    public function __construct()
    {
        parent::__construct();

        $this->collaborators = new ArrayCollection();
        $this->children = new ArrayCollection();
//        $this->comment = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    public function getCreatedAt()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updated;
    }
    public function setUpdatedAt($updated)
    {
        $this->updated = $updated;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return User
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * @param User $reporter
     */
    public function setReporter(User $reporter)
    {
        $this->reporter = $reporter;
    }

    /**
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @param User $reporter
     */
    public function setAssignee(User $assignee)
    {
        $this->assignee = $assignee;
    }

    /**
     * @param WorkflowItem $workflowItem
     * @return Issue
     */
    public function setWorkflowItem($workflowItem)
    {
        $this->workflowItem = $workflowItem;

        return $this;
    }

    /**
     * @return WorkflowItem
     */
    public function getWorkflowItem()
    {
        return $this->workflowItem;
    }

    /**
     * @param WorkflowItem $workflowStep
     * @return Issue
     */
    public function setWorkflowStep($workflowStep)
    {
        $this->workflowStep = $workflowStep;

        return $this;
    }

    /**
     * @return WorkflowStep
     */
    public function getWorkflowStep()
    {
        return $this->workflowStep;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Issue $issue
     */
    public function setParent(Issue $issue)
    {
        $this->parent = $issue;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

}
