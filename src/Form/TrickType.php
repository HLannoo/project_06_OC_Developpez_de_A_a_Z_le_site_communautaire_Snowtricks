<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class)
            ->add('description', TextareaType::class)
            ->add('category', EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' =>'name',
                    'mapped'=>false,
                ])
            ->add('mainImage', FileType::class, [
                'label' => 'Image Principale (Taille maximum supportée : '.ini_get('post_max_size').')',
                'mapped' => false,
                'required' => false,
                'attr'     => [
                    'accept' => 'image/*'
                ]])

            ->add('images', FileType::class, [
                'label' => 'Images secondaires (Taille maximum supportée : '.ini_get('post_max_size').')',
                'mapped' => false,
                'required' => false,
                'multiple'=>true,
                'attr'     => [
                    'accept' => 'image/*',
                    'multiple' => 'multiple'
                ]])

            ->add('videos', CollectionType::class, [
                'entry_type'=> VideoType::class,
                'label'=>'videos',
                'entry_options'=>['label'=>false],
                'allow_add'=>true,
                'allow_delete'=>true,
                'by_reference'=>false,
                'required' => false,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
            'images'=>null,

        ]);
    }
}
