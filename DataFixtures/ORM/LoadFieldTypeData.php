<?php
namespace Talan\Bundle\DynamicFormBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Talan\Bundle\DynamicFormBundle\Entity\FieldType;

/**
 *
 * @author aymen.bouchekoua <aymen.bouchakoua@talan.tn>
 *
 */
class LoadFieldTypeData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $objects = array(
				array('textInput', 1),
				array('textArea', 2),
				array('checkbox', 3),
				array('radio', 3),
				array('select', 1),
		);
        foreach ($objects as $object) {
            $newObject = new FieldType();
            $newObject->setName($object[0]);
            $newObject->setValueDisc($object[1]);
            $manager->persist($newObject);
//             $this->addReference('project-'.$newObject->getId(), $newObject);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}