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
use Knp\Component\Pager\PaginatorInterface;

class OfferController extends AbstractController
{
    /**
     * @Route("/offermanager", name="app_offer")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $repository=$this->getDoctrine()->getRepository(Offer::class);
        $offers=$repository->findAll();
        $pagedOffers = $paginator->paginate(
            $offers, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
        return $this->render('offer/offermanager.html.twig', ["offers"=>$pagedOffers]
        );
    }
      /**
     * @Route("/offerlist", name="offerlist")
     */
    public function offerList(Request $request, PaginatorInterface $paginator): Response
    {
        $repository=$this->getDoctrine()->getRepository(Offer::class);
        $offers=$repository->findAll();
        $pagedOffers = $paginator->paginate(
            $offers, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );

        return $this->render('offer/offerlist.html.twig', ["offers"=>$pagedOffers]
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
        $offer = new Offer();
        $offer->setUser($this->getUser());
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
  /**
     * @Route("/back/offerchecker", name="offerchecker")
     */
    public function offerChecker(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Offer::class);
        $offers=$repository->findAll();
        return $this->render('offer/offerback.html.twig', ["offers"=>$offers]
        );
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
