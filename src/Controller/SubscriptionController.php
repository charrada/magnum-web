<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Subscription;

class SubscriptionController extends AbstractController
{
    /**
     * @Route("/subscription", name="app_subscription")
     */
    public function index(): Response
    {
        return $this->render('subscription/index.html.twig', [
            'controller_name' => 'SubscriptionController',
        ]);
    }
    /**
     * @Route("/back/subscriptionchecker", name="subscriptionchecker")
     */
    public function subscriptionChecker(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Subscription::class);
        $subs=$repository->findAll();
        return $this->render('subscription/subscriptionback.html.twig', ["subs"=>$subs]
        );
    }
}
