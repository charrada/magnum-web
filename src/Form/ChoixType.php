<?php

namespace App\Form;

use App\Entity\Tickettype;
use App\Entity\Ticket;

use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\Integer;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use function PHPUnit\Framework\stringContains;

class ChoixType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        //->add('type')
        ->add('type', EntityType::class,['class'=>TicketType::class,
        'placeholder'=>'SELECT TYPE OF TICKET',
        'choice_label' => function($choix){
            return $choix->getitype() . ' - ' . $choix->gettype();

        }
        ])
        ->add('SEND',SubmitType::class)
       

            
        ;
       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
