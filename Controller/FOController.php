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

class FOController extends Controller
{
    public function formAction(Form $form)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        if (!$form) throw new NotFoundHttpException();

        if ($request->isMethod('POST')) {
            $fields = $request->request->get('fields');
//             var_dump($fields);
//             die;
            foreach ($fields as $fieldId => $fieldValue) {
                $field = $em->getRepository('TalanDynamicFormBundle:Field')->find($fieldId);
                $value = $em->getRepository('TalanDynamicFormBundle:Value')->findOneByField($fieldId);
                if (!$value) $value = Value::getInstanceByType($field->getFieldType()->getValueDisc());
                $value->setValue($fieldValue);
                $value->setField($field);
                $em->persist($value);
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('dynamicForm.fo.message.success'));
            return $this->redirect($this->generateUrl('talan_dynamic_fo_form', array(
                'form' => $form->getId()
            )));
        }

        return $this->render('TalanDynamicFormBundle:FO:index.html.twig', array(
            'form' => $form,
        ));
    }

    public function getFieldsAction(Form $form)
    {
        $jsonFields = $this->get('talan_dynamic_form.json_parser')
            ->getJsonFromFields($form->getFields());

        return new JsonResponse($jsonFields);
    }

    public function getValuesAction(Form $form)
    {
        $jsonValues = $this->get('talan_dynamic_form.json_parser')
            ->getFormValues($form);
        return new JsonResponse($jsonValues);
    }
}
