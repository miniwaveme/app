<?php

namespace AppBundle\Form\Handler;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class EntityFormHandler
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

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

            $this->registry->getManager()->persist($entity);
            $this->registry->getManager()->flush();

            return $entity;
        }

        return $form;
    }
}