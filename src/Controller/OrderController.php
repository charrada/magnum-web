<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;
use App\Entity\Offer; 
use App\Entity\Users;
use App\Entity\Subscription;
use App\Entity\Coupon;
use App\Repository\UsersRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\String\ByteString;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Dompdf\Dompdf;
use Dompdf\Options;



class OrderController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }
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
        return $this->render('order/chooseplan.html.twig',["offers"=>$offers]);
      
    }

    /**
     *@Route("/placeorder/{id}",name="placeorder")
     */
    public function placeOrder(Request $request,int $id,MailerInterface $mailer,UsersRepository $userRepo){

        $repository=$this->getDoctrine()->getRepository(Offer::class);
        $offers=$repository->find($id);

        $curr_user = $this->security->getUser();  

        $order = new Order();      
        $date = date('Y-m-d H:i:s:v');
        $order->setOrderdate($date);
        $order->setStatus("Pending");
        $order->setUser($curr_user);
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
           $subscription->setUserId($curr_user->getID());
           
           $subcreated = new \DateTime('NOW');
           $subscription->setStartDate(new \DateTime('NOW'));
           $day = $subcreated->format('j');
           $subcreated->modify('first day of'.$plan*+1 . 'month');
           $subcreated->modify('+' . (min($day, $subcreated->format('t')) - 1) . ' days');;
          
           
           $subscription->setExpireDate($subcreated);
           $subscription->setStatus("On Hold");
       
          $em->persist($subscription);  
          $em ->flush();
         
        $repository=$this->getDoctrine()->getRepository(Coupon::class);
        $inputCoupon =$request->request->get('code');
        try
         {
        if ($inputCoupon != ""){
        $taggedCoupon=$repository->findOneBy(array('code' => $inputCoupon));
        $em = $this->getDoctrine()->getManager();
        $em->persist($taggedCoupon->setUsed("true"));
        $em ->flush();}
        } catch (\Throwable $t) {
            return new JsonResponse($order->getId());
        }


        $email = (new TemplatedEmail())
        ->from('devel.magnum@gmail.com')
        ->to($curr_user->getEmail())
        ->subject('About your order !')
        ->htmlTemplate('email/order.html.twig')
        ->context([
          'order' => $order
        ]);

          $mailer->send($email);


     
         return new JsonResponse($order->getId());
   //  return $this->render('payment/index.html.twig',["order"=>$order]);
      
        
    }
    /**
     *@Route("/redeem-coupon",name="redeem")
     */
    public function redeemCoupon(Request $request){

        $repository=$this->getDoctrine()->getRepository(Coupon::class);
        $inputCoupon =$request->request->get('code');
        $taggedCoupon=$repository->findOneBy(array('code' => $inputCoupon));

        $curr_user = $this->security->getUser();  
        try
        {
        if (($taggedCoupon->getUsed() == "false") && ($curr_user->getID() == $taggedCoupon->getUserId())){

           
            return new JsonResponse($taggedCoupon->getReduction()); 


        }
       } catch (\Throwable $t) {
        return new JsonResponse(0);
       }
  
        return new JsonResponse(0); 
    }

         /**
     * @Route("/back/orderchecker", name="orderchecker")
     */
    public function orderChecker(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Order::class);
        $orders=$repository->findAll();
        return $this->render('order/orderback.html.twig', ["orders"=>$orders]
        );
    }

    /**
     * @Route("/orderspdf",name="orderspdf")
     */
    public function generateOrderPdf()
    {
        $repository=$this->getDoctrine()->getRepository(Order::class);
        $orderlist=$repository->findAll();

        $pdfoptions=new Options();
        $pdfoptions->set('defaultFont','Arial');
        $pdfoptions->set('isHtml5ParserEnabled',true);
        $pdfoptions->set('isRemoteEnabled',true);
        $dompdf= new Dompdf($pdfoptions);
        $html=$this->renderView('order/pdf.html.twig',[
            'orderlist'=>$orderlist
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','landscape');

        $dompdf->render();
        $dompdf->stream("OrderList.pdf", ["Attachment"=>false]);


    }
    /**
     *@Route("/placeordermobile",name="placeordermobile")
     */
    public function placeOrderForMobile(Request $request,MailerInterface $mailer){

        $id = $request->get("id");
        $repository=$this->getDoctrine()->getRepository(Offer::class);
        $offers=$repository->find($id);

        $curr_user = $this->security->getUser();  
        $repositoryuser=$this->getDoctrine()->getRepository(Users::class);
        $iduser =1;
        $users=$repositoryuser->find($iduser);

        $order = new Order();      
        $date = date('Y-m-d H:i:s:v');
        $order->setOrderdate($date);
        $order->setStatus("Pending");
        $order->setUser($users);
        $order->setOffer($offers);
        $plan =$request->get('plan');
        $total =$request->get('total');
        $order->setPlan($plan);
        $order->setTotal($total);

          try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em ->flush();

            $repository=$this->getDoctrine()->getRepository(Order::class);
            $lastOrder=$repository->find($order->getId());

           $subscription = new Subscription();
           $subscription->setOrder($lastOrder);
           $subscription->setUserId($curr_user->getID());
           
           $subcreated = new \DateTime('NOW');
           $subscription->setStartDate(new \DateTime('NOW'));
           $day = $subcreated->format('j');
           $subcreated->modify('first day of'.$plan*+1 . 'month');
           $subcreated->modify('+' . (min($day, $subcreated->format('t')) - 1) . ' days');;
          
           
           $subscription->setExpireDate($subcreated);
           $subscription->setStatus("On Hold");
       
          $em->persist($subscription);  
          $em ->flush();

            return new JsonResponse("Order created!", 200);
        }
        catch (\Exception $ex)
        {
            return new Response("Execption: ".$ex->getMessage());
        }
     
          
         
       /* $repository=$this->getDoctrine()->getRepository(Coupon::class);
        $inputCoupon =$request->request->get('code');
        try
         {
        if ($inputCoupon != ""){
        $taggedCoupon=$repository->findOneBy(array('code' => $inputCoupon));
        $em = $this->getDoctrine()->getManager();
        $em->persist($taggedCoupon->setUsed("true"));
        $em ->flush();}
        } catch (\Throwable $t) {
            return new JsonResponse($order->getId());
        }


        $email = (new TemplatedEmail())
        ->from('devel.magnum@gmail.com')
        ->to($curr_user->getEmail())
        ->subject('About your order !')
        ->htmlTemplate('email/order.html.twig')
        ->context([
          'order' => $order
        ]);

          $mailer->send($email);


     
         return new JsonResponse($order->getId());
   //  return $this->render('payment/index.html.twig',["order"=>$order]);*/
      
        
    }


}
