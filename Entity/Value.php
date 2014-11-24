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

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Talan\Bundle\DynamicFormBundle\Entity\Field
     */
    private $field;

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
     * Get A value instance depending on the type
     *
     * @param integer $valueType
     * @return \Talan\Bundle\DynamicFormBundle\Entity\IntegerValue|\Talan\Bundle\DynamicFormBundle\Entity\StringValue
     */
    public static function getInstanceByType($valueType)
    {
        switch ($valueType) {
            case self::ARRAY_VALUE:
                return new ArrayValue();
            default:
                return new StringValue();
        }
    }
}
