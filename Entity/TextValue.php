<?php

namespace Talan\Bundle\DynamicFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TextValue
 */
class TextValue extends Value
{
    /**
     * @var string
     */
    private $value;


    /**
     * Set value
     *
     * @param string $value
     * @return TextValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
