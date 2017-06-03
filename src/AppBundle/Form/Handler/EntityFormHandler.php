<?php

namespace AppBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class EntityFormHandler
{
    /**
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return mixed|FormInterface
     */
    public function handle(FormInterface $form, Request $request)
    {
        $method = $request->getMethod();
        $form->submit($request->request->all(), 'PATCH' !== $method);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();

            return $entity;
        }

        return $form;
    }
}