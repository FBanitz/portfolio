<?php

namespace App\Form;

use App\Entity\Projets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Ex.: Magasin d\'équipement de cuisine'
                ]
            ])
            ->add('description', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex.: Sité créé lors d\'un examen de 4h avec page de connexion, CRUD...'
                ]
            ])
            ->add('img', FileType::class, [
                'help' => 'png, jpg ou jpeg - 1 Mo maximum',
                'required' => true,
                'mapped' => false,
                'label' => 'Image',
                'attr' => [
                    'placeholder' => 'Image d\'illustration'
                ]
            ])
            ->add('lien', TextType::class, [
                'help' => 'lien sans http(s):// ni www.',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex.: monsite.fr'
                ]
            ])
            ->add('duree', IntegerType::class, [
                'help' => 'durée de production en heures',
                'required' => false,
                'attr' => [
                    'placeholder' => '4'
                ]
            ])
            ->add('sujet', TextType::class, [
                'help' => 'lien du sujet sans http(s):// ni www.',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex.: monsite.fr/sujet.pdf'
                ]
            ])
            ->add('valider', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projets::class,
        ]);
    }
}
