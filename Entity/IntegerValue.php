<?php

namespace Talan\Bundle\DynamicFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IntegerValue
 */
class IntegerValue extends Value
{
    /**
     * @var integer
     */
    private $value;


    /**
     * Set value
     *
     * @param integer $value
     * @return IntegerValue
     */
    public function setValue($value)
    {
        if (is_array($value)) {
            $value =  intval(array_keys($value)[0]);
        }
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }
}
