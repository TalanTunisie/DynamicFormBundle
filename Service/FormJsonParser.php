<?php
namespace Talan\Bundle\DynamicFormBundle\Service;

use Talan\Bundle\DynamicFormBundle\Entity\Field;
use Talan\Bundle\DynamicFormBundle\Entity\Form;
use Talan\Bundle\DynamicFormBundle\Entity\FieldType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class FormJsonParser
{
    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Get fields from json
     *
     * @param string $json
     * @param Form $form
     *
     * @return array of Field
     */
    public function getFieldsFromJson($json, Form $form)
    {
        $jsonArray = json_decode($json);
        $fields = array();
        foreach ($jsonArray as $jsonField) {
            $field = $form->getId() && isset($jsonField->id) ?
                $this->em->getRepository('TalanDynamicFormBundle:Field')->find($jsonField->id) : null; // Modify or add a new field
            if (!$field) {
                $field = new Field();
            }
            $field->setForm($form);
            $field->setLabel($jsonField->label);
            $field->setDescription($jsonField->description);
            $field->setPlaceholder($jsonField->placeholder);
            $field->setIsRequired($jsonField->required);
            if (is_array($jsonField->options)) {
                $field->setOptions($jsonField->options);
            }
            $field->setIndex($jsonField->index);
            $field->setValidation($jsonField->validation);
            $fieldType = $this->em->getRepository('TalanDynamicFormBundle:FieldType')->findOneByName($jsonField->component);
            $field->setFieldType($fieldType);

            $fields[] = $field;
        }
        return $fields;
    }

    public function getJsonFromFields($fields, $valueOwner)
    {
        $jsonArray = array();
        foreach ($fields as $field) {
            $jsonField = array();
            $jsonField['id']            = $field->getId();
            $jsonField['label']         = $field->getLabel();
            $jsonField['description']   = $field->getDescription();
            $jsonField['placeholder']   = $field->getPlaceholder();
            $jsonField['component']     = $field->getFieldType()->getName();
            $jsonField['required']      = $field->getIsRequired();
            $jsonField['options']       = $field->getOptions();
            $jsonField['index']         = $field->getIndex();
            $jsonField['validation']    = $field->getValidation();
            $jsonField['value']         = $this->getFieldValueByOwner($field, $valueOwner);

            $jsonArray[] = $jsonField;
        }
        return $jsonArray;
    }

    private function getFieldValueByOwner($field, $valueOwner)
    {
        $value = $this->em->getRepository('TalanDynamicFormBundle:Value')->findOneBy(array(
            "field" => $field->getId(),
            "valueOwner" => $valueOwner
        ));
        if (!$value) return null;
        $value = $value->getValue();

        if (is_array($value)) {
            $value = array_map(function($a){return $a == 1;}, $value);
        }

        return $value;
    }

    public function removeFields(Form $form, $newFields)
    {
        $oldFields = $form->getFields();
        foreach ($oldFields as $oldField) {
            if (!in_array($oldField, $newFields)) {
                $oldField->setForm(null);
                $this->em->persist($oldField);
            }
        }
        $this->em->flush();
    }

}