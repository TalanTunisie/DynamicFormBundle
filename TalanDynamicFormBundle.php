<?php

namespace Talan\Bundle\DynamicFormBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Talan\Bundle\DynamicFormBundle\DependencyInjection\Compiler\ValueOwnerProviderCompilerPass;

class TalanDynamicFormBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ValueOwnerProviderCompilerPass());
    }
}
