<?php

namespace Talan\Bundle\DynamicFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Value
 */
abstract class Value extends AbstractEntity
{
    const STRING_VALUE  = 1;
    const TEXT_VALUE    = 2;
    const ARRAY_VALUE   = 3;
    const INTEGER_VALUE = 4;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Talan\Bundle\DynamicFormBundle\Entity\Field
     */
    private $field;

    /**
     * @var String
     */
    private $valueOwner;

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
     * Get A value instance depending on the type
     * @param Integer $valueType
     * @return \Talan\Bundle\DynamicFormBundle\Entity\ArrayValue|\Talan\Bundle\DynamicFormBundle\Entity\IntegerValue|\Talan\Bundle\DynamicFormBundle\Entity\TextValue|\Talan\Bundle\DynamicFormBundle\Entity\StringValue
     */
    public static function getInstanceByType($valueType)
    {
        switch ($valueType) {
            case self::ARRAY_VALUE:
                return new ArrayValue();
            case self::INTEGER_VALUE:
                return new IntegerValue();
            case self::TEXT_VALUE:
                return new TextValue();
            default:
                return new StringValue();
        }
    }

    /**
     * Set field
     *
     * @param \Talan\Bundle\DynamicFormBundle\Entity\Field $field
     * @return Value
     */
    public function setField(\Talan\Bundle\DynamicFormBundle\Entity\Field $field = null)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return \Talan\Bundle\DynamicFormBundle\Entity\Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set value
     *
     * @param unknown $value
     * @return Value
     */
    public abstract function setValue($value);

    /**
     * Get value
     *
     * @return unknown
     */
    public abstract function getValue();

    /**
     * Set valueOwner
     *
     * @param string $valueOwner
     * @return Value
     */
    public function setValueOwner($valueOwner)
    {
        $this->valueOwner = $valueOwner;

        return $this;
    }

    /**
     * Get valueOwner
     *
     * @return string
     */
    public function getValueOwner()
    {
        return $this->valueOwner;
    }
}
