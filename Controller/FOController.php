<?php

namespace Talan\Bundle\DynamicFormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Talan\Bundle\DynamicFormBundle\Entity\Form;
use Talan\Bundle\DynamicFormBundle\Entity\Value;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Talan\Bundle\DynamicFormBundle\Entity\Field;
use Talan\Bundle\DynamicFormBundle\Entity\StringValue;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class FOController extends Controller
{
    public function formAction(Form $form)
    {
        // Security Checks
        if (!$form) throw new NotFoundHttpException();

        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {
            $fields = $request->request->get('fields');
            if ($form->getValueOwnerAlias() != null) {
                $valueOwner = $this->get('talan_dynamic_form.value_owner_provider_chain')
                                    ->getValueOwnerProvider($form->getValueOwnerAlias())
                                    ->getValueOwner();
            }
            foreach ($fields as $fieldId => $fieldValue) {
                $field = $em->getRepository('TalanDynamicFormBundle:Field')->find($fieldId);
                $valueSearchCriteria = array("field" => $fieldId);
                if(isset($valueOwner))
                    $valueSearchCriteria["valueOwner"] = $valueOwner;
                $value = $em->getRepository('TalanDynamicFormBundle:Value')->findOneBy($valueSearchCriteria);
                if (!$value) $value = Value::getInstanceByType($field->getFieldType()->getValueDisc());
                $value->setValue($fieldValue);
                $value->setField($field);
                if(isset($valueOwner))
                    $value->setValueOwner($valueOwner);

                $em->persist($value);
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('dynamicForm.fo.message.success'));
            return $this->redirect($this->generateUrl('talan_dynamic_form_fo', array(
                'form' => $form->getId()
            )));
        }

        return $this->render('TalanDynamicFormBundle:FO:index.html.twig', array(
            'form' => $form,
        ));
    }

    public function getFieldsAction(Form $form, $valueOwner)
    {
        if (!$valueOwner) {
            $valueOwner = $form->getValueOwnerAlias() != null ? $this->get('talan_dynamic_form.value_owner_provider_chain')
                ->getValueOwnerProvider($form->getValueOwnerAlias())
                ->getValueOwner($form) : null;
        }
        $jsonFields = $this->get('talan_dynamic_form.json_parser')
            ->getJsonFromFields($form->getFields(), $valueOwner);
        return new JsonResponse($jsonFields);
    }
}
