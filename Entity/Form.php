<?php

namespace Talan\Bundle\DynamicFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Form
 */
class Form extends AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $valueOwnerAlias;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $fields;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fields = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Form
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Form
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
     * Set valueOwnerAlias
     *
     * @param string $valueOwnerAlias
     * @return Form
     */
    public function setValueOwnerAlias($valueOwnerAlias)
    {
        $this->valueOwnerAlias = $valueOwnerAlias;

        return $this;
    }

    /**
     * Get valueOwnerAlias
     *
     * @return string
     */
    public function getValueOwnerAlias()
    {
        return $this->valueOwnerAlias;
    }

    /**
     * Add fields
     *
     * @param \Talan\Bundle\DynamicFormBundle\Entity\Field $fields
     * @return Form
     */
    public function addField(\Talan\Bundle\DynamicFormBundle\Entity\Field $fields)
    {
        $this->fields[] = $fields;

        return $this;
    }

    /**
     * Remove fields
     *
     * @param \Talan\Bundle\DynamicFormBundle\Entity\Field $fields
     */
    public function removeField(\Talan\Bundle\DynamicFormBundle\Entity\Field $fields)
    {
        $this->fields->removeElement($fields);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set Fields
     *
     * @param array $fields
     * @return \Talan\Bundle\DynamicFormBundle\Entity\Form
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }
}
