<?php

namespace App\Form;

use App\Entity\Recette;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
//use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $type = 1;

        $builder
            ->add('titre', TextType::class)
            ->add('tempsTotal', IntegerType::class, [
                'label' => 'Temps total (min)',
                'attr' => [
                    'max' => 300,
                ],
            ])
            // ->add('slug')
            ->add('tempsPreparation', IntegerType::class, [
                'label' => 'Temps de préparation (min)',
                'attr' => [
                    'max' => 300,
                ],
            ])
            ->add('tempsCuisson', IntegerType::class, [
                'label' => 'Temps de cuisson (min)',
                'required' => false,
                'attr' => [
                    'max' => 300,
                ],
            ])
            ->add('instruction', CKEditorType::class, [
                'label' => 'Instructions'
            ])
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
                'class' => Categorie::class,
                'query_builder' => function(CategorieRepository $repository) use($type) {
                    return $repository->categorietype($type);
                }
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('type');
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
