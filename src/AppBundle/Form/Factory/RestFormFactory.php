<?php

namespace AppBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;

class RestFormFactory
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * @param FormFactoryInterface $factory
     */
    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Create the form with the given type.
     *
     * @param $type
     * @param object $data
     * @param array  $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function create($type, $data = null, array $options = [])
    {
        return $this->factory->create($type, $data, $options);
    }
}