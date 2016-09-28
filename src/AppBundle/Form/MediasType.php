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
        // a déplacer
        $years = [];
        for($i = 1950;$i <= 2020;$i++) {
            $years[$i] = $i;
        }

        $builder
            ->add('type', ChoiceType::class,
                array(
                    'choices' => array('film' => 'medias.form.movie', 'serie' => 'medias.form.tv_show'),
                    'expanded' => true,
                    'multiple' => false
                )
            )
            ->add('status', ChoiceType::class,
                array(
                    'choices' => array('vu' => 'medias.already_seen', 'pas_vu' => 'medias.never_seen'),
                    'expanded' => true,
                    'multiple' => false
                )
            )
            ->add('image', FileType::class, array('label' => 'medias.form.media_poster'))
            ->add('nom', TextType::class)
            ->add('realisateurs', TextType::class)
            ->add('acteurs', TextType::class)
            ->add('description', TextareaType::class)
            ->add('trailer', TextType::class)
            ->add('annee', DateType::class, array(
                'widget' => 'choice',
                'years' => $years,
                'label' => 'medias.year'
            ))
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
