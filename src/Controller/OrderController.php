<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;
use App\Entity\Offer; 
use App\Entity\Users;
use App\Entity\Subscription;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;



class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="app_order")
     */
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

        /**
     * @Route("/chooseplan/{id}", name="chooseplan")
     */
    public function choosePlan(Request $request, int $id): Response
    {
        $repository=$this->getDoctrine()->getRepository(Offer::class);
        $offers=$repository->find($id);

        $repository=$this->getDoctrine()->getRepository(Users::class);
        $id = 5;
        $user=$repository->find($id);

        return $this->render('order/chooseplan.html.twig',["offers"=>$offers]);
      
    
     
 
    }

    /**
     *@Route("/placeorder/{id}",name="placeorder")
     */
    public function placeOrder(Request $request,int $id){
        $repository=$this->getDoctrine()->getRepository(Offer::class);
        $offers=$repository->find($id);

        $repository=$this->getDoctrine()->getRepository(Users::class);
        $id = 5;
        $user=$repository->find($id);

        $order = new Order();      
        $date = date('Y-m-d H:i:s:v');
        $order->setOrderdate($date);
        $order->setStatus("Pending");
        $order->setUser($user);
        $order->setOffer($offers);
        $plan =$request->request->get('plan');
        $total =$request->request->get('total');
        $order->setPlan($plan);
        $order->setTotal($total);
       
      
          $em = $this->getDoctrine()->getManager();
          $em->persist($order);
          $em ->flush();
     
          $repository=$this->getDoctrine()->getRepository(Order::class);
          $lastOrder=$repository->find($order->getId());

           $subscription = new Subscription();
           $subscription->setOrder($lastOrder);
           $subscription->setUserId($id);
           
           $subcreated = new \DateTime('NOW');
           $subscription->setStartDate(new \DateTime('NOW'));
           $day = $subcreated->format('j');
           $subcreated->modify('first day of'.$plan*+1 . 'month');
           $subcreated->modify('+' . (min($day, $subcreated->format('t')) - 1) . ' days');;
          
           
           $subscription->setExpireDate($subcreated);
           $subscription->setStatus("On Hold");
       
          $em->persist($subscription);  
          $em ->flush();
      

     
         return new JsonResponse($order->getId());
   //  return $this->render('payment/index.html.twig',["order"=>$order]);
      
        
    }

}
