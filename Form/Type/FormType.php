<?php
namespace Talan\Bundle\DynamicFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormType extends AbstractType
{
    private $aliases;

    public function __construct($aliases)
    {
        $this->aliases = $aliases;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => 'dynamicForm.bo.name',
            'label_attr' => array(
                'class' => 'col-md-4 control-label'
            ),
            'attr' => array(
                'class' => 'form-control'
            )
        ))
            ->add('description', 'textarea', array(
            'label' => 'dynamicForm.bo.description',
            'label_attr' => array(
                'class' => 'col-md-4 control-label'
            ),
            'attr' => array(
                'class' => 'form-control'
            )
        ))
            ->add('submit', 'submit', array(
            'label' => 'dynamicForm.btn.save',
            'attr' => array(
                'class' => 'btn btn-primary'
            )
        ))
            ->add('reset', 'reset', array(
            'label' => 'dynamicForm.btn.reset',
            'attr' => array(
                'class' => 'btn btn-default'
            )
        ));

        if (count($this->aliases) > 0) {
            $builder->add('valueOwnerAlias', 'choice', array(
                'label' => 'dynamicForm.bo.valueOwnerAlias',
                'label_attr' => array(
                    'class' => 'col-md-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control'
                ),
                'choices' => $this->aliases,
                'required' => false,
                'empty_value' => '',
                'empty_data' => null
            ));
        }

        return $builder;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Talan\Bundle\DynamicFormBundle\Entity\Form',
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return "form_type";
    }
}