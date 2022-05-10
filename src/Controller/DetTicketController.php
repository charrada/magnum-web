<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Ticket;
use App\Entity\Ticketkind;
use App\Entity\Tickettype;
use App\Form\DetTicketType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use function PHPSTORM_META\type;

class DetTicketController extends AbstractController
{
    /**
     * @Route("/det/test", name="app_det_ticket")
     */
    public function index(): Response
    {
        return $this->render('det_ticket/index.html.twig', [
            'controller_name' => 'DetTicketController',
        ]);
    }

    /**
     * @Route("/det/ticket/{tt}/",name="ticket")
     */
    public function Det(Request $request,$tt): Response
    {    
        $t= new Ticket();
        $t1= new Ticketkind();
        
        $t->setstatus('Pending');
        $t->setresolverid('');
        $t->setid(random_int(100, 999));
        $form=$this->createForm(DetTicketType::class,$t);
        $t1->setid($t->getid());
        $t1->settype($tt);
       // 
        //fn 3ala 9rib tged lfaza edhika
      // $t1->setitype($tr.);
        //$t1->setitype($ts->getitype());
        $tr=$this->getDoctrine()->getManager()->getRepository(Tickettype::class)->findOneBy(['type'=>$tt]);
        $t1->setitype($tr->getitype());

      // $form->add('NEXT',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($t);
            $em->flush();

            
            $em1=$this->getDoctrine()->getManager();
            $em1->persist($t1);
            $em1->flush();
        
            return $this->redirectToRoute('app_det_ticket');
        }
        
        return $this->render('det_ticket/det.html.twig',['f'=>$form->createView()]);
        
    }
}
