<?php
namespace Talan\Bundle\DynamicFormBundle\Tests\Service;

use Talan\Bundle\DynamicFormBundle\Service\FormJsonParser;
use Talan\Bundle\DynamicFormBundle\Entity\Form;
use Talan\Bundle\DynamicFormBundle\Entity\Field;
use Talan\Bundle\DynamicFormBundle\Entity\FieldType;

class FormJsonParserTest extends \PHPUnit_Framework_TestCase
{

    public function testGetFieldsFromJson()
    {
        $service = new FormJsonParser($this->getEntityManager());

        $jsonInput = '[{"id":"textbox","component":"textInput","editable":false,"index":0,"label":"Name","description":"Your name","placeholder":"Your name","options":[],"required":true,"validation":"/.*/"},{"component":"textArea","editable":true,"index":1,"label":"Text Area","description":"description","placeholder":"placeholder","options":[],"required":false,"validation":"/.*/"},{"id":"checkbox","component":"checkbox","editable":true,"index":2,"label":"Pets","description":"Do you have any pets?","placeholder":"placeholder","options":["Dog","Cat"],"required":false,"validation":"/.*/"},{"component":"checkbox","editable":true,"index":3,"label":"Checkbox","description":"description","placeholder":"placeholder","options":["value one","value two"],"required":false,"validation":"/.*/"},{"component":"select","editable":true,"index":4,"label":"Select","description":"description","placeholder":"placeholder","options":["value one","value two"],"required":false,"validation":"/.*/"}]';

        $form = new Form();
        $fields = $service->getFieldsFromJson($jsonInput, $form);

        $inputTextField = $fields[0];
        $this->assertTrue($inputTextField->getForm() == $form);
        $this->assertTrue($inputTextField->getFieldType()->getName() == "textInput");
        $this->assertTrue($inputTextField->getDescription() == "Your name");
        $this->assertTrue($inputTextField->getPlaceholder() == "Your name");
        $this->assertTrue($inputTextField->getIsRequired() == true);
        $this->assertTrue($inputTextField->getIndex() == 0);
        $this->assertTrue($inputTextField->getValidation() == "/.*/");
        $this->assertTrue($inputTextField->getOptions() == array());
    }

    private function getEntityManager()
    {
        $fieldTypeRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $fieldTypeRepository->expects($this->any())
            ->method('findAll')
            ->will($this->returnValue($this->getFieldTypes()));

        $entityManager = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($fieldTypeRepository));

        return $entityManager;
    }

    private function getFieldTypes()
    {
        $fieldTypes = array();
        $objects = array(
            array('textInput', 1),
            array('textArea', 2),
            array('checkbox', 3),
            array('radio', 4),
            array('select', 4)
        );
        foreach ($objects as $object) {
            $newObject = new FieldType();
            $newObject->setName($object[0]);
            $newObject->setValueDisc($object[1]);
            $fieldTypes[] = $newObject;
        }

        return $fieldTypes;
    }
}