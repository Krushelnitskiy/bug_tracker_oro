<?php

namespace Oro\Bundle\TrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * Class Resolution
 *
 * @package Tracker\IssueBundle\Entity
 * @ORM\Table(name="oro_tracker_issue_resolution")
 * @Gedmo\TranslationEntity(class="Oro\Bundle\TrackerBundle\Entity\ResolutionTranslation")
 * @ORM\Entity
 * @Config()
 */
class Resolution
{
    const RESOLUTION_FIXED = 'Fixed';
    const RESOLUTION_WONT_FIX = 'Won`t fix';
    const RESOLUTION_DONE = 'Done';
    const RESOLUTION_WONT_DO = 'Won`t done';

    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="`name`", type="string", length=30, unique=true)
     * @ConfigField(
     *  defaultValues={
     *      "importexport"={
     *          "identity"=true
     *      }
     *  }
     * )
     */
    protected $name;

    /**
     * @var string $label
     *
     * @ORM\Column(name="label", type="string", unique=true)
     * @Gedmo\Translatable
     */
    protected $label;

    /**
     * @var integer $order
     *
     * @ORM\Column(name="`order`", type="integer", nullable=false, options={"default":0})
     */
    protected $order;

    /**
     * @var string $locale
     *
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
     *
     * @return Resolution
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
     *
     * @return Resolution
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
     *
     * @return Resolution
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
     *
     * @return Resolution
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
