<?php
namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\InputType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class BackendEditUserType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add("id", TextType::class, [
                "label" => 'User ID',
                "disabled" => true,
                "attr" => ["class" => "form-control"],
            ])
            ->add("email", EmailType::class, [
                "label" => 'Email',
                "disabled" => true,
                "attr" => ["class" => "form-control"],
            ])
            ->add("username", TextType::class, [
                "label" => 'Username',
                "disabled" => true,
                "attr" => ["class" => "form-control"],
            ])
            ->add("status", ChoiceType::class, [
                "label" => 'Status',
                "attr" => ["class" => "form-control"],
                'choices'  => [
                    'Active' => 'Active',
                    'Disabled' => 'Disabled',
                    'Banned' => 'Banned',
                ],
            ])
            ->add("edit", SubmitType::class, [
                "attr" => ["class" => "btn btn-warning"],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Users::class,
        ]);
    }
}
