<?php

namespace App\Form;

use App\Entity\Recette;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('tempsTotal', IntegerType::class)
            ->add('tempsPreparation', IntegerType::class)
            ->add('tempsCuisson', IntegerType::class)
            ->add('instruction', TextareaType::class)
            ->add('image', TextType::class)
            ->add('difficulte', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 5
                ],
            ])
            //->add('date_publication')
            //->add('utilisateur')
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
