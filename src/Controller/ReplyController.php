<?php

namespace App\Controller;

use App\Repository\ChatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Chat;
use App\Entity\Ticket;
use Symfony\Component\HttpFoundation\Request;
class ReplyController extends AbstractController
{
    /**
     * @Route("/reply", name="aa2")
     */
    public function index(): Response
    {
        return $this->render('reply/index.html.twig', [
            'controller_name' => 'ReplyController',
        ]);
    }




  /**
     * @Route("/reply/message/{i}", name="msg")
     */
    public function message($i,ChatRepository $rep,Request $req): Response
    {
        $data=$req->get('text');
        $data2=$req->get('text2');

          echo $data;
            $c= new chat();  
            $c->setid($i);
            $c->setmsg($data);
            //tahaaziz
            $c->setresolverid("24");
            
            $c->setdatem(date('d-m-y h:i:s'));
            $c->setifrom('Resolver');
              $em=$this->getDoctrine()->getManager();
               $em->persist($c);
               $em->flush();
               return $this->redirectToRoute('aa',['id'=>$i]);
    }



    /**
     * @Route("/reply/{id}/", name="aa")
     */
    public function chat($id,ChatRepository $rep,Request $req): Response
    {
        echo $id;

        $chat=$this->getDoctrine()->getManager()->getRepository(Chat::class)->findBy(['id'=>$id]);
        return $this->render('reply/index.html.twig',['c'=>$chat,'i'=>$id]);
        
    }




}
