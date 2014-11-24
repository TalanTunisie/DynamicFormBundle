<?php
namespace Talan\Bundle\DynamicFormBundle\DBAL;


class FieldTypeEnum extends AbstractEnumType
{
    protected $name = 'field_type_enum';
    protected $values = array('string', 'integer', 'date', 'datetime', 'array');
}