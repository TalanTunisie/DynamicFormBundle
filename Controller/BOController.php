<?php

namespace Talan\Bundle\DynamicFormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Talan\Bundle\DynamicFormBundle\Entity\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Talan\Bundle\DynamicFormBundle\Form\Type\FormType;

class BOController extends Controller
{
    public function formAction(Form $form = null)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $aliases = $this->get('talan_dynamic_form.value_owner_provider_chain')->getValueOwnerAliases();

        if (!$form) {
            $form = new Form();
        }

        $formView = $this->createForm(new FormType($aliases), $form, array(
            'action' => $this->generateUrl('talan_dynamic_form_bo', array('form' => $form->getId()))
        ));
        $formView->handleRequest($request);
        if ($formView->isValid()) {
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
            'formView'  => $formView->createView(),
            'form'      => $form,
        ));
    }

    public function formListAction()
    {
        $forms = $this->getDoctrine()->getRepository('TalanDynamicFormBundle:Form')->findAll();
        return $this->render('TalanDynamicFormBundle:BO:formList.html.twig', array(
            'forms'     => $forms
        ));
    }

    public function ownerListAction($formId)
    {
        $ownerLists = $this->getDoctrine()->getRepository('TalanDynamicFormBundle:Value')->findOwnersByForm($formId);
        return $this->render('TalanDynamicFormBundle:BO:ownerList.html.twig', array(
            'ownerList'     => $ownerLists,
            'formId'        => $formId
        ));
    }


    public function removeAction(Form $form)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($form);
        $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('dynamicForm.bo.message.remove', array(
            '%id%' => $form->getId()
        )));
        $em->flush();

        return $this->redirect($this->generateUrl('talan_dynamic_form_bo', array(
            'form' => $form->getId(),
        )));
    }

}
