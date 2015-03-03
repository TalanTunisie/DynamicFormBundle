<?php
namespace Talan\Bundle\DynamicFormBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use Talan\Bundle\DynamicFormBundle\Service\AbstractValueOwnerProvider;
use Doctrine\ORM\EntityManager;

abstract class AbstractUserValueProvider extends AbstractValueOwnerProvider
{
	protected $security;
	protected $em;

	public function __construct(EntityManager $em,SecurityContext $security)
	{
		$this->security = $security;
		$this->em = $em;
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
