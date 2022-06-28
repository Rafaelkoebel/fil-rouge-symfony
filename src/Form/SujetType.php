<?php

namespace App\Form;

use App\Entity\Sujet;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SujetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $type = 'sujet';

        $builder
            ->add('titre', TextType::class)
            // ->add('slug')
            ->add('contenu', CKEditorType::class)
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
            'data_class' => Sujet::class,
        ]);
    }
}
