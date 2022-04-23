<?php
namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add("username", TextType::class, [
                "label" => false,
                "attr" => [
                    "class" => "form-control",
                    "placeholder" => "Username",
                ],
            ])
            ->add("email", EmailType::class, [
                "label" => false,
                "attr" => ["class" => "form-control", "placeholder" => "Email"],
            ])
            ->add("password", PasswordType::class, [
                "label" => false,
                "attr" => [
                    "class" => "form-control",
                    "placeholder" => "Password",
                ],
            ])
            ->add("avatar", FileType::class, [
                "label" => "Upload an avatar",
                "mapped" => true,
                "required" => false,
                "constraints" => [
                    new File([
                        "maxSize" => "4096k",
                        "mimeTypes" => ["image/png", "image/jpeg"],
                        "mimeTypesMessage" =>
                            "Please upload an image file (IMG, JPEG)",
                    ]),
                ],
            ])
            ->add("register", SubmitType::class, [
                "attr" => ["class" => "btn oneMusic-btn mt-30"],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Users::class,
        ]);
    }
}
