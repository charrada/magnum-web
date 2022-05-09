<?php

namespace App\Form;

use App\Entity\Podcasts;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PodcastsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('rating')
            ->add('views')
            ->add('file', FileType::class , [ 'mapped'=> false]) 
            ->add('image', FileType::class , [ 'mapped'=> false])    
            ->add('idcategorie' , EntityType::class, array(
                'class' => 'App\Entity\Categorie',
                'choice_label' => function ($Categ){ 
                   
                    return $Categ->getNamecateg();}
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Podcasts::class,
        ]);
    }
}
