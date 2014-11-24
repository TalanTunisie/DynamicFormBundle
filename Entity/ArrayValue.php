<?php

namespace Talan\Bundle\DynamicFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArrayValue
 */
class ArrayValue extends Value
{
    /**
     * @var array
     */
    private $value;


    /**
     * Set value
     *
     * @param array $value
     * @return ArrayValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return array
     */
    public function getValue()
    {
        return $this->value;
    }
}
