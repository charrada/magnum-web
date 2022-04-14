<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('authorID')
            ->add('titre')
            ->add('url')
            ->add('content')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
            $resolver->setDefaults([
                'data_class' => Article::class,
            ]);
        
    }
}
