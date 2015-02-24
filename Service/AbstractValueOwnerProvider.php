<?php
namespace Talan\Bundle\DynamicFormBundle\Service;

use Talan\Bundle\DynamicFormBundle\Service\ValueOwnerProviderInterface;

abstract class AbstractValueOwnerProvider implements ValueOwnerProviderInterface
{

    /**
     * Set the default value of the owner template
     *
     * (non-PHPdoc)
     * @see \Talan\Bundle\DynamicFormBundle\Service\ValueOwnerProviderInterface::getOwnerTemplate()
     */
    public function getOwnerListTemplate()
    {
        return 'TalanDynamicFormBundle:OwnerList:default.html.twig';
    }

    /**
     * (non-PHPdoc)
     * @see \Talan\Bundle\DynamicFormBundle\Service\ValueOwnerProviderInterface::getValueOwner()
     */
    public abstract function getValueOwner();
}