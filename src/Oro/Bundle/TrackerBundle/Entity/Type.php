<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.03.15
 * Time: 14:35
 */


namespace Oro\Bundle\TrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Type
 * @package Oro\TrackerBundle\Entity
 * @ORM\Table(name="oro_tracker_issue_type")
 * @ORM\Entity
 */

class Type
{
    const TYPE_BUG = 'Bug';
    const TYPE_SUB_TASK = 'Subtask';
    const TYPE_TASK = 'Task';
    const TYPE_STORY = 'Story';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="`name`", type="string", length=30, unique=true)
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
     * @ORM\Column(name="`order`", type="integer", nullable=false, options={"default":0}))
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
