<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19.02.15
 * Time: 18:59
 */

namespace Oro\Bundle\TrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * Class Priority
 * @package Tracker\IssueBundle\Entity
 * @ORM\Table(name="oro_tracker_issue_priority")
 * @Gedmo\TranslationEntity(class="Oro\Bundle\TrackerBundle\Entity\PriorityTranslation")
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
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "identity"=true
     *      }
     *  }
     * )
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
     * @Gedmo\Translatable
     */
    protected $label;

    /**
     * @var integer
     *
     * @ORM\Column(name="`order`", type="integer", nullable=false, options={"default":0})
     */
    protected $order;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

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
     * @return Priority
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

    /**
     * @param $order
     * @return Priority
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param $name
     * @return Priority
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set locale for translation
     *
     * @param string $locale
     * @return Priority
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->label;
    }
}
