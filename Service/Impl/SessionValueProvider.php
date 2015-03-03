<?php
namespace Talan\Bundle\DynamicFormBundle\Service\Impl;

use Symfony\Component\HttpFoundation\Session\Session;
use Talan\Bundle\DynamicFormBundle\Service\AbstractValueOwnerProvider;

class SessionValueProvider extends AbstractValueOwnerProvider
{
    protected $session;
    protected $em;
    
    public function __construct(EntityManager $em,Session $session)
    {
        $this->session = $session;
        $this->em = $em;
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
