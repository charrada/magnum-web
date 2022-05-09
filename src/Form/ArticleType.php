<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;



class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('authorID')
            ->add('title')
            ->add('content')
            ->add('url',FileType::class,array('data_class' => null),
            array(
                'label' => 'file(pdf)',
                'mapped'=>false,
                'required'=>false,
               
        ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
            $resolver->setDefaults([
                'data_class' => Article::class,
            ]);
        
    }
}
