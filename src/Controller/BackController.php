<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;
use App\Entity\Subscription;

class BackController extends AbstractController
{
    /**
     * @Route("/back", name="app_back")
     */
    public function index(): Response
    {
        return $this->render('back/back.base.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function loadCards(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Order::class);
        $subRepository=$this->getDoctrine()->getRepository(Subscription::class);
        $orders=$repository->findBy(['status' => "Completed"]);
        $total = 0;
        $orderCount =0;
        $topSeller = $repository ->findBy(
            array('status' => "Completed"),
            array('total' => 'ASC'),       
            1,                        // $limit
            0                          // $offset
          );
        foreach ($orders as $order)
        {
            $total+=($order->getTotal());
            $orderCount +=1;
        }
        $user ="";
        foreach ($topSeller as $order)
        {
            $user=($order->getUser()->getUsername());
        }


        $active = $subRepository->findBy(['status' => "Active"]);
        $onhold = $subRepository->findBy(['status' => "On Hold"]);
        $expired = $subRepository->findBy(['status' => "Expired"]);
        $activeCount =0;
        $onholdCount =0;
        $expiredCount =0;
        $em = $this->getDoctrine()->getManager();
        foreach ($active as $sub)
        {  
            if ($sub->isExpired()) {
                $sub->setStatus("expired");
                $em->persist($sub);  
                $em ->flush();
            }

            $activeCount +=1;
        }
        foreach ($onhold as $sub)
        {
            $onholdCount +=1;
        }
        foreach ($expired as $sub)
        {
            $expiredCount +=1;
        }



        return $this->render('back/cards.html.twig', [
            'total' => $total,
            'orderCount' => $orderCount,
            'topSeller' => $user,
            'activeCount' => $activeCount,
            'onholdCount' => $onholdCount,
            'expiredCount' => $expiredCount,
        ]);
    }
}
