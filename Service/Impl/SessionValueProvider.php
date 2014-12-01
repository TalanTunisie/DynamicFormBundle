<?php
namespace Talan\Bundle\DynamicFormBundle\Service\Impl;

use Talan\Bundle\DynamicFormBundle\Service\ValueOwnerProviderInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionValueProvider implements ValueOwnerProviderInterface
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