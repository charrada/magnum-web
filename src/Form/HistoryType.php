<?php
namespace App\Form;

use App\Entity\History;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class HistoryType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('activity', ChoiceType::class, [
                'label' => 'Activity',
                'choices' => [
                    'All' => 'All',
                    'Security' => 'Security',
                    'Billing' => 'Billing',
                    'Profile' => 'Profile',
                ],
                'attr' => [ "class" => "form-control" ],
            ])
            ->add("clear", SubmitType::class, [
                "attr" => ["class" => "btn btn-danger"],
            ])
            ->add("filter", SubmitType::class, [
                "attr" => ["class" => "btn btn-primary"],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => History::class,
        ]);
    }
}
