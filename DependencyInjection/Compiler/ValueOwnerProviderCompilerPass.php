<?php
namespace Talan\Bundle\DynamicFormBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 *
 * @author aymen.bouchekoua <aymen.bouchakoua@talan.tn>
 *
 */
class ValueOwnerProviderCompilerPass implements CompilerPassInterface
{

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('talan_dynamic_form.value_owner_provider_chain')) {
            return;
        }

        $definition = $container->getDefinition(
            'talan_dynamic_form.value_owner_provider_chain'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'talan_dynamic_form.value_owner_provider'
        );

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall(
                    'addValueOwnerProvider',
                    array(new Reference($id), $attributes["alias"])
                );
            }
        }
    }
}