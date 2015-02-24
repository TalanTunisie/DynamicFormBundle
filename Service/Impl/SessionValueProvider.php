<?php
namespace Talan\Bundle\DynamicFormBundle\Service\Impl;

use Symfony\Component\HttpFoundation\Session\Session;
use Talan\Bundle\DynamicFormBundle\Service\AbstractValueOwnerProvider;

class SessionValueProvider extends AbstractValueOwnerProvider
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * (non-PHPdoc)
     * @see \Talan\Bundle\DynamicFormBundle\Service\ValueOwnerProviderInterface::getValueOwner()
     */
    public function getValueOwner()
    {
        return $this->session->getId();
    }
}