<?php

namespace App\Controller;

use App\Entity\Coupon;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Entity\Order;
use App\Entity\Subscription;
use App\Entity\Users;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\String\ByteString;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment")
     */
    public function index(): Response
    {
        return $this->render('payment/index.html.twig');
    }


      /**
     * @Route("/checkout/{order}", name="checkout")
     */
    public function checkout(int $order): Response
    {
           Stripe::setApiKey('sk_test_51KUO54LURk8bHQH66NOA9MpsReXKIXeXkjRe76TuRYFEhjeWw4aFTG1OLaM0oYe62iZFrcGq4Q1kYDQ9ZjNVQeue00pExVMjwm');
            $repository=$this->getDoctrine()->getRepository(Order::class);
            $orders=$repository->find($order);
            $repository=$this->getDoctrine()->getRepository(Subscription::class);
            $subs=$repository->findOneBy(array('order' => $orders));
            $total=$orders->getTotal();
            $plan =$orders->getPlan();
            $repository=$this->getDoctrine()->getRepository(Users::class);
            $id = 1;
            $user=$repository->find($id);
            $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => 'Subsciption',
                        ],
                        'unit_amount'  => $total*100,
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', ["session_id" => $order], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
           
        ]);
    
        $status = $session->retrieve($session->id,
            []
          );

           

              if(str_contains($session->url,'success-url')){
       

            }
         

        return $this->redirect($session->url, 303);
    }

     /**
     * @Route("/success-url", name="success_url")
     */
    public function successUrl(Request $request,MailerInterface $mailer): Response
    {
        $order = $request->query->get('session_id');
        $repository=$this->getDoctrine()->getRepository(Order::class);
            $orders=$repository->find($order);
            $repository=$this->getDoctrine()->getRepository(Subscription::class);
            $subs=$repository->findOneBy(array('order' => $orders));
            $total=$orders->getTotal();
            $plan =$orders->getPlan();
            $repository=$this->getDoctrine()->getRepository(Users::class);
            $id = 1;
            $user=$repository->find($id);
            $orders->setStatus("Completed");
            $subs->setStatus("Active");
             $em = $this->getDoctrine()->getManager();
             $em->persist($orders);
             $em->persist($subs);
             
             if ($plan >= 3 && $plan <= 5){
                $coupon = new Coupon(); 
                $coupon->setUserId($id);
                $coupon->setCode(ByteString::fromRandom(12)->toString());
                $coupon->setReduction(10);
                $coupon->setUsed("false");
                $coupon->setCreated(new \DateTime('NOW'));
                $em->persist($coupon);
                $email = (new TemplatedEmail())
                ->from('devel.magnum@gmail.com')
                ->to($user->getEmail())
                ->subject('You\'ve recieved a new coupon')
                ->htmlTemplate('email/coupon.html.twig')
                ->context([
                  'coupon' => $coupon
                ]);
    
                $mailer->send($email);

             }
             else if ($plan >= 6 && $plan <= 12){
                $coupon = new Coupon(); 
                $coupon->setUserId($id);
                $coupon->setCode(ByteString::fromRandom(12)->toString());
                $coupon->setReduction(20);
                $coupon->setUsed("false");
                $coupon->setCreated(new \DateTime('NOW'));
                $em->persist($coupon);
                $email = (new TemplatedEmail())
                ->from('devel.magnum@gmail.com')
                ->to($user->getEmail())
                ->subject('You\'ve recieved a new coupon')
                ->htmlTemplate('email/coupon.html.twig')
                ->context([
                  'coupon' => $coupon
                ]);
                $mailer->send($email);
            }
            $email = (new TemplatedEmail())
            ->from('devel.magnum@gmail.com')
            ->to($user->getEmail())
            ->subject('About your order !')
            ->htmlTemplate('email/order.html.twig')
            ->context([
              'order' => $orders
            ]);
    
           // $mailer->send($email);
            $em ->flush();
        return $this->render('payment/success.html.twig', ["orders" => $orders]);
    }

   
     /**
     * @Route("/cancel-url", name="cancel_url")
     */
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }
}
