<?php
namespace Talan\Bundle\DynamicFormBundle\DBAL;


class FieldTypeEnum extends AbstractEnumType
{
    protected $name = 'field_type_enum';
    protected $values = array(  'textInput'     => 1,
                                'textArea'      => 2,
                                'checkbox'      => 3,
                                'radio'         => 4,
                                'select'        => 5,
    );

}