<?php
namespace App\Form;

use App\Entity\Tokens;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class GenerateTokenType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add("username", TextType::class, [
                "required" => true,
                "label" => "What's your username?",
                "label_attr" => [
                    "class" => "col-sm-2 col-form-label"
                ],
                "attr" => [
                    "id" => "username",
                    "class" => "form-control",
                    "placeholder" => "Username"
                ],
            ])
            ->add("generate", SubmitType::class, [
                "attr" => ["class" => "btn btn-primary mb-2"],
            ])
            ->add("skip", SubmitType::class, [
                "label" => "I already have a token",
                "attr" => ["class" => "btn btn-link mb-2"],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Users::class,
            "attr" => [
                "class" => "form-inline",
              ]
        ]);
    }
}
