<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.03.15
 * Time: 14:35
 */


namespace Oro\Bundle\TrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Class Type
 * @package Oro\TrackerBundle\Entity
 * @ORM\Table(name="oro_tracker_issue_type")
 * @Gedmo\TranslationEntity(class="Oro\Bundle\TrackerBundle\Entity\TypeTranslation")
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
     * @Gedmo\Translatable
     */
    protected $label;

    /**
     * @var integer
     *
     * @ORM\Column(name="`order`", type="integer", nullable=false, options={"default":0}))
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

    /**
     * @param $order
     * @return Type
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
     * @return Type
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
     * @return Type
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
