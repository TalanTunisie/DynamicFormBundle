<?php
namespace Talan\Bundle\DynamicFormBundle\Tests\Service;

use Talan\Bundle\DynamicFormBundle\Tests\BaseTestCase;
use Talan\Bundle\DynamicFormBundle\Service\FormJsonParser;
use Talan\Bundle\DynamicFormBundle\Entity\Form;
use Talan\Bundle\DynamicFormBundle\Entity\Field;

class FormJsonParserTest extends BaseTestCase
{

    /**
     * @var FormJsonParser
     */
    private $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = $this->get('talan_dynamic_form.json_parser');
    }

    public function testServiceInstance()
    {
        $this->assertTrue($this->service instanceof FormJsonParser);
    }

    public function testGetFieldsFromJson()
    {
        $jsonInput = '[{"id":"textbox","component":"textInput","editable":false,"index":0,"label":"Name","description":"Your name","placeholder":"Your name","options":[],"required":true,"validation":"/.*/"},{"component":"textArea","editable":true,"index":1,"label":"Text Area","description":"description","placeholder":"placeholder","options":[],"required":false,"validation":"/.*/"},{"id":"checkbox","component":"checkbox","editable":true,"index":2,"label":"Pets","description":"Do you have any pets?","placeholder":"placeholder","options":["Dog","Cat"],"required":false,"validation":"/.*/"},{"component":"checkbox","editable":true,"index":3,"label":"Checkbox","description":"description","placeholder":"placeholder","options":["value one","value two"],"required":false,"validation":"/.*/"},{"component":"select","editable":true,"index":4,"label":"Select","description":"description","placeholder":"placeholder","options":["value one","value two"],"required":false,"validation":"/.*/"}]';

        $form = new Form();
        $fields = $this->service->getFieldsFromJson($jsonInput, $form);

        $inputTextField = $fields[0];
//         $inputTextField = new Field();
        $this->assertTrue($inputTextField->getForm() == $form);
        $this->assertTrue($inputTextField->getFieldType()->getName() == "textInput");
        $this->assertTrue($inputTextField->getDescription() == "Your name");
        $this->assertTrue($inputTextField->getPlaceholder() == "Your name");
        $this->assertTrue($inputTextField->getIsRequired() == true);
        $this->assertTrue($inputTextField->getIndex() == 0);
        $this->assertTrue($inputTextField->getValidation() == "/.*/");
        $this->assertTrue($inputTextField->getOptions() == array());
    }
}