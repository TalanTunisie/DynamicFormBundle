<?php
namespace Talan\Bundle\DynamicFormBundle\Service;

/**
 *
 * @author aymen.bouchekoua <aymen.bouchakoua@talan.tn>
 *
 */
interface ValueOwnerProviderInterface
{
    /**
     * Returns the owner of the current entree
     */
    public function getValueOwner();

    /**
     * Returns a specific template for this provider
     */
    public function getOwnerListTemplate();
}