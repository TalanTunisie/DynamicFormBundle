<?php

namespace Talan\Bundle\DynamicFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FieldType
 */
class FieldType
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
     * @return FieldType
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

    public function __toString() {
        return $this->name;
    }
    /**
     * @var string
     */
    private $valueDisc;


    /**
     * Set valueDisc
     *
     * @param string $valueDisc
     * @return FieldType
     */
    public function setValueDisc($valueDisc)
    {
        $this->valueDisc = $valueDisc;

        return $this;
    }

    /**
     * Get valueDisc
     *
     * @return string
     */
    public function getValueDisc()
    {
        return $this->valueDisc;
    }
}
