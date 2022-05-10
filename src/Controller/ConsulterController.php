<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Chat;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Ticket;
use App\Entity\Tickettype;

use App\Form\ConsulterType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ChatRepository;
use App\Repository\TicketRepository;

class ConsulterController extends AbstractController
{
    /**
     * @Route("/consulter/show/{userid}" ,name="show")
     */
    public function index($userid,Request $req): Response
    {


        $t= new Ticket();
        $form=$this->createForm(ConsulterType::class,$t);
        $form->handleRequest($req);


        $ticket=$this->getDoctrine()->getManager()->getRepository(Ticket::class)->findBy(['userid'=>$userid]);
        $typ=$this->getDoctrine()->getManager()->getRepository(Tickettype::class)->findAll();
        return $this->render('consulter/consulter.html.twig',['t'=>$ticket,'typ'=>$typ]);



    
    }





    /**
     * @Route("/consulter/message/{i}/{userid}", name="msg1")
     */
    public function message($i,$userid,ChatRepository $rep,Request $req): Response
    {
        $data=$req->get('text');
        

          echo $data;
            $c= new chat();  
            $c->setid($i);
            $c->setmsg($data);
            //tahaaziz
            $c->setuserid($userid);
            $c->setresolverid("");
            $c->setdatem(date('d-m-y h:i:s'));
            $c->setifrom('User');
              $em=$this->getDoctrine()->getManager();
               $em->persist($c);
               $em->flush();
               return $this->redirectToRoute('ha2',['id'=>$i,'userid'=>$userid]);
    }


   /**
     * @Route("/consulter/{id}/{userid}", name="ha2")
     */
    public function chat($id,$userid,Request $req): Response
    {

        $t= new Ticket();
        $form=$this->createForm(ConsulterType::class,$t);
        $form->handleRequest($req);


        echo $id;

        $chat=$this->getDoctrine()->getManager()->getRepository(Chat::class)->findBy(['id'=>$id]);
        return $this->render('consulter/index.html.twig',['f4'=>$form->createView(),'c'=>$chat,'i'=>$id,'userid'=>$userid]);
        
    }






     /**
     * @Route("/consulter/test/{userid}/{id}/{eva}", name="ev")
     */
    public function update($id,$userid,$eva,TicketRepository $rep): Response
    {
        echo $eva;
        $ticket=new Ticket();
        $ticket=$rep->find(['id'=>$id]);
        $ticket->setevaluate($eva);
        $em=$this->getDoctrine()->getManager();
        
        $em->flush();
        return $this->redirectToRoute('show',['userid'=>$userid]);
    }




  
    

}
