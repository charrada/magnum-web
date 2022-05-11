<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Tickettype;
use App\Form\ChoixType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
class ChoixController extends AbstractController
{
    /**
     * @Route("/choix", name="choix")
     */
    public function index(): Response
    {
        //echo $t->gettype();;
        return $this->render('choix/index.html.twig', [
            'controller_name' => 'ChoixController',
        ]);
    }


      /**
     * @Route("/choix")
     */
    public function Deta(Request $request): Response
    {
      
        $t= new Tickettype();
        $form=$this->createForm(ChoixType::class,$t);
        //$form->add('id',TextType::class);
        $form->add('NEXT',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            
            //$em=$this->getDoctrine()->getManager();
           // $em->persist($t);
            //$em->flush();
            return $this->redirectToRoute('choix',[
                't'=>$t]);
        }
        
        return $this->render('choix/choix.html.twig',['f'=>$form->createView()]);
        
    }
    



    
     /**
     * @Route("/choix/add",name="add")
     */
    public function choix(Request $request): Response
    {    
        $t= new Tickettype();
        $form=$this->createForm(ChoixType::class,$t);
        //$form->add('NEXT',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $choix=$request->request->get('itype');
               //echo $t->gettype();
          
          //  $s=$form->get('choix',TextType::class);
            //$em=$this->getDoctrine()->getManager();
           // $em->persist($t);
            //$em->flush();
            return $this->redirectToRoute('ticket',['tt'=>$t->gettype()]);

           //return $this->render('det_ticket/det.html.twig',['f'=>$form->createView(),'ts'=>$t->gettype()]);    

        }
        
        
        return $this->render('choix/choix.html.twig',['f'=>$form->createView(),'ts'=>$t->gettype()]);
        
    }

}
