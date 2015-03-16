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

/**
 * Class Issue
 * @package Oro\Bundle\TrackerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(
 *      name="oro_tracker_issue",
 * )
 * @Config(

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


//    /**
//     * @ORM\ManyToOne(targetEntity="Type")
//     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
//     **/
//    protected $type;

//    /**
//     * @ORM\ManyToOne(targetEntity="Priority")
//     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id")
//     **/
//    protected $priority;
//
//
//    /**
//     * @ORM\ManyToOne(targetEntity="Resolution")
//     * @ORM\JoinColumn(name="resolution_id", referencedColumnName="id")
//     **/
//    protected $resolution;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="\Tracker\UserBundle\Entity\User")
//     * @ORM\JoinColumn(name="reporter_id", referencedColumnName="id")
//     **/
//    protected $reporter;

//    /**
//     * @ORM\ManyToOne(targetEntity="\Tracker\UserBundle\Entity\User", inversedBy="assignedIssue")
//     * @ORM\JoinColumn(name="assignee_id", referencedColumnName="id")
//     **/
//    protected $assignee;

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
     * @ORM\ManyToOne(targetEntity="Issue", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    protected $parent;


    /**
     * @ORM\Column(type="date")
     **/
    protected $created;

    /**
     * @ORM\Column(type="date")
     **/
    protected $updated;


    public function __construct()
    {
        parent::__construct();

        $this->collaborators = new ArrayCollection();
        $this->children = new ArrayCollection();
//        $this->comment = new ArrayCollection();
    }
}



