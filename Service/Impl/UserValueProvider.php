<?php
namespace Talan\Bundle\DynamicFormBundle\Service\Impl;

use Talan\Bundle\DynamicFormBundle\Service\ValueOwnerProviderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;

class UserValueProvider implements ValueOwnerProviderInterface
{
    private $security;

    public function __construct(SecurityContext $security)
    {
        $this->security = $security;
    }

    /**
     * (non-PHPdoc)
     * @see \Talan\Bundle\DynamicFormBundle\Service\ValueOwnerProviderInterface::getValueOwner()
     */
    public function getValueOwner()
    {
        if (!$this->security) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->security->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
}