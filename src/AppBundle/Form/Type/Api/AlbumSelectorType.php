<?php

namespace AppBundle\Form\Type\Api;

use AppBundle\Form\DataTransformer\AlbumTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumSelectorType extends AbstractType
{
    /**
     * @var AlbumTransformer
     */
    protected $transformer;

    /**
     * @param AlbumTransformer $transformer
     */
    public function __construct(AlbumTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer($this->transformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'The user does not exist',
        ]);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'text';
    }
}