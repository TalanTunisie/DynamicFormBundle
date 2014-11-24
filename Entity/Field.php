<?php

namespace Talan\Bundle\DynamicFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Field
 */
class Field extends AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $isRequired;

    /**
     * @var string
     */
    private $placeholder;

    /**
     * @var \Talan\Bundle\DynamicFormBundle\Entity\FieldType
     */
    private $fieldType;

    /**
     * @var \Talan\Bundle\DynamicFormBundle\Entity\Form
     */
    private $form;


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
     * @return Field
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
     * Set description
     *
     * @param string $description
     * @return Field
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
     * Set isRequired
     *
     * @param boolean $isRequired
     * @return Field
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    /**
     * Get isRequired
     *
     * @return boolean
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }

    /**
     * Set placeholder
     *
     * @param string $placeholder
     * @return Field
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get placeholder
     *
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set fieldType
     *
     * @param \Talan\Bundle\DynamicFormBundle\Entity\FieldType $fieldType
     * @return Field
     */
    public function setFieldType(\Talan\Bundle\DynamicFormBundle\Entity\FieldType $fieldType = null)
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    /**
     * Get fieldType
     *
     * @return \Talan\Bundle\DynamicFormBundle\Entity\FieldType
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * Set form
     *
     * @param \Talan\Bundle\DynamicFormBundle\Entity\Form $form
     * @return Field
     */
    public function setForm(\Talan\Bundle\DynamicFormBundle\Entity\Form $form = null)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return \Talan\Bundle\DynamicFormBundle\Entity\Form
     */
    public function getForm()
    {
        return $this->form;
    }
    /**
     * @var string
     */
    private $options;


    /**
     * Set options
     *
     * @param string $options
     * @return Field
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }
    /**
     * @var integer
     */
    private $index;

    /**
     * @var string
     */
    private $validation;


    /**
     * Set index
     *
     * @param integer $index
     * @return Field
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * Get index
     *
     * @return integer
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Set validation
     *
     * @param string $validation
     * @return Field
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * Get validation
     *
     * @return string
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Use in comparison in_array
     *
     * @return number
     */
    function __toString() {
        return $this->id;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $values;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->values = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add values
     *
     * @param \Talan\Bundle\DynamicFormBundle\Entity\Value $values
     * @return Field
     */
    public function addValue(\Talan\Bundle\DynamicFormBundle\Entity\Value $values)
    {
        $this->values[] = $values;

        return $this;
    }

    /**
     * Remove values
     *
     * @param \Talan\Bundle\DynamicFormBundle\Entity\Value $values
     */
    public function removeValue(\Talan\Bundle\DynamicFormBundle\Entity\Value $values)
    {
        $this->values->removeElement($values);
    }

    /**
     * Get values
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getValues()
    {
        return $this->values;
    }
}
