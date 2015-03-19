<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19.02.15
 * Time: 18:59
 */

namespace Oro\Bundle\TrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Priority
 * @package Tracker\IssueBundle\Entity
 * @ORM\Table(name="oro_tracker_issue_priority")
 * @ORM\Entity
 */

class Priority
{
    const PRIORITY_TRIVIAL = 'Trivial';
    const PRIORITY_MINOR = 'Minor';
    const PRIORITY_MAJOR = 'Major';
    const PRIORITY_CRITICAL = 'Critical';
    const PRIORITY_BLOCKER = 'Blocker';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=30, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", unique=true)
     */
    protected $label;

    /**
     * @var integer
     *
     * @ORM\Column(name="order", type="integer")
     */
    protected $order;

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
     * Set label
     *
     * @param string $label
     * @return Type
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->label;
    }
}
