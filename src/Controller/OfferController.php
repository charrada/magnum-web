<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offer; 
use App\Entity\Users; 
use App\Repository\OfferRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\OfferType;

class OfferController extends AbstractController
{
    /**
     * @Route("/offermanager", name="app_offer")
     */
    public function index(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Offer::class);
        $offers=$repository->findAll();
        return $this->render('offer/offermanager.html.twig', ["offers"=>$offers]
        );
    }
      /**
     * @Route("/offerlist", name="offerlist")
     */
    public function offerList(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Offer::class);
        $offers=$repository->findAll();
        return $this->render('offer/offerlist.html.twig', ["offers"=>$offers]
        );
    }
      /**
     * @Route("/selectedoffer/{id}", name="selectedoffer")
     */
    public function selectedOffer(int $id): Response
    {
        $repository=$this->getDoctrine()->getRepository(Offer::class);
        $offers=$repository->find($id);
        return $this->render('offer/selectedoffer.html.twig', ["offers"=>$offers]
        );
    }

 
 
    /**
     *@Route("/addoffer",name="addoffer")
     */
    public function addOffer(Request $request){
        $repository=$this->getDoctrine()->getRepository(Users::class);
        $id = 5;
        $user=$repository->find($id);
        $offer = new Offer();
        $offer->setUser($user);
        $form = $this->createForm(OfferType::class,$offer);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('img_directory'),
                $fileName
            );
            $offer->setImage($fileName);
          $offer = $form->getData();
          $em = $this->getDoctrine()->getManager();
          $em->persist($offer);
          $em ->flush();
          return $this->redirectToRoute('app_offer');
      }

       return $this->render("offer/addoffer.html.twig", ["form"=>$form->createView()]);

    }
    /**
    * @Route("/editoffer/{id}", name="editoffer")
    */

    public function editOffer(Request $request, int $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();

    $offer = $entityManager->getRepository(Offer::class)->find($id);
    $form = $this->createForm(OfferType::class, $offer);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
        $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('img_directory'),
                $fileName
            );
            $offer->setImage($fileName);
            $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('app_offer');
    }

    return $this->render("offer/addoffer.html.twig", ["form" => $form->createView()]);
}

  //  /**
 //    * @Route("/deleteoffer/{id}",name="deleteoffer")
 //    */
  /*  public function deleteOffer($id)

    {
        $em=$this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($id);
        $em->flush();

        return $this->redirectToRoute("app_offer");
    }*/

}
