<?php

namespace Talan\Bundle\DynamicFormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Talan\Bundle\DynamicFormBundle\Entity\Form;
use Symfony\Component\HttpFoundation\JsonResponse;

class BOController extends Controller
{
    public function formAction(Form $form = null)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        if (!$form) {
            $form = new Form();
        }
        if ($request->isMethod('POST')) {
            $form->setName($request->request->get('form-name'));
            $form->setDescription($request->request->get('form-description'));
            $fields = $this->get('talan_dynamic_form.json_parser')
                        ->getFieldsFromJson($request->request->get('form-json'), $form);
            $this->get('talan_dynamic_form.json_parser')->removeFields($form, $fields);
            $form->setFields($fields);

            $em->persist($form);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('dynamicForm.bo.message.success'));
            return $this->redirect($this->generateUrl('talan_dynamic_form_bo', array(
                'form' => $form->getId(),
            )));
        }
        return $this->render('TalanDynamicFormBundle:BO:index.html.twig', array(
            'form'      => $form,
        ));
    }

}
