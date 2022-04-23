<?php
namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class SecurityDetailsType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add("password", PasswordType::class, [
                "label" => 'Current password',
                "required" => true,
                "attr" => [
                    "class" => "form-control",
                ],
            ])
            ->add("new_password", PasswordType::class, [
                "label" => 'New password',
                "required" => true,
                "attr" => [
                    "class" => "form-control",
                ],
            ])
            ->add("password_confirm", PasswordType::class, [
                "label" => 'Confirm password',
                "required" => true,
                "attr" => [
                    "class" => "form-control",
                ],
            ])
            ->add("confirm", SubmitType::class, [
                "attr" => ["class" => "btn btn-primary"],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Users::class,
        ]);
    }
}
