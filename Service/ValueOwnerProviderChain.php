<?php
namespace Talan\Bundle\DynamicFormBundle\Service;

class ValueOwnerProviderChain
{

    private $valueOwnerProviders;
    private $aliases;

    public function __construct()
    {
        $this->valueOwnerProviders = array();
        $this->aliases = array();
    }

    public function addValueOwnerProvider(ValueOwnerProviderInterface $valueOwnerProvider, $alias)
    {
        $this->valueOwnerProviders[$alias] = $valueOwnerProvider;
        $this->aliases[] = $alias;
    }

    public function getValueOwnerAliases()
    {
        return $this->aliases;
    }

    public function getValueOwnerProvider($aliasId)
    {
        if (array_key_exists($this->aliases[$aliasId], $this->valueOwnerProviders)) {
            return $this->valueOwnerProviders[$this->aliases[$aliasId]];
        }
    }
}