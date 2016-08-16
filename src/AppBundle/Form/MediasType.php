<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class,
                array(
                    'choices' => array('film' => 'Film', 'serie' => 'Série'),
                    'expanded' => true,
                    'multiple' => false
                )
            )
            ->add('status')
            ->add('image', FileType::class, array('label' => 'Affiche du film ou de la série :'))
            ->add('nom', TextType::class)
            ->add('realisateurs', TextType::class)
            ->add('acteurs', TextType::class)
            ->add('description', TextareaType::class)
            ->add('trailer', TextType::class)
            ->add('annee', DateType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Medias'
        ));
    }
}
