<?php

namespace AppBundle\Form\Type\Api;

use AppBundle\Form\DataTransformer\ArtistTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistSelectorType extends AbstractType
{
    /**
     * @var ArtistTransformer
     */
    protected $transformer;

    /**
     * @param ArtistTransformer $transformer
     */
    public function __construct(ArtistTransformer $transformer)
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