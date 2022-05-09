<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Podcasts;
use App\Repository\PodcastsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class PodcastApiController extends AbstractController
{
    /**
     * @Route("/AfficherPodcastsMobile", name="AfficherPodcastsMobile")
     */
    public function AfficherPodcastsMobile(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository(Podcasts::class)->findAll();

        return $this->json($commandes,200,[],['groups'=>'post:read']);

        //http://127.0.0.1:8000/AfficherPodcastsMobile

    }
    /**
     * @Route("/SupprimerPodcastsMobile", name="SupprimerPodcastsMobile")
     */
    public function SupprimerPodcastsMobile(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Podcasts::class)->find($id);
        if($commande!=null ) {
            $em->remove($commande);
            $em->flush();

            return new JsonResponse("Podcasts Supprime!", 200);
        }
        return new JsonResponse("ID Podcasts Invalide.");


    }
    /**
     * @Route("/AjouterPodcastsMobile", name="AjouterPodcastsMobile")
     */
    public function AjouterPodcastsMobile(Request $request)
    {
        $commande = new Podcasts();
        $commande->setTitle($request->get("Title"));
        $commande->setDescription($request->get("Description"));
        $commande->setRating($request->get("Rating"));
        $commande->setViews($request->get("Views"));
        $commande->setFile($request->get("File"));
        $commande->setImage($request->get("Image"));
        $idCategorie = $request->get("idCategorie");
        $commande->setIdcategorie($this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($idCategorie));
        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return new JsonResponse("Podcasts Ajoute!", 200);
        }
        catch (\Exception $ex)
        {
            return new Response("Execption: ".$ex->getMessage());
        }

        //http://127.0.0.1:8000/AjouterPodcastsMobile?Title=json&Description=json&Rating=5&Views=0&File=json&Image=json&idCategorie=8


    }
    /**
     * @Route("/ModifierPodcastsMobile", name="ModifierPodcastsMobile")
     */
    public function ModifierPodcastsMobile(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $this->getDoctrine()->getManager()
            ->getRepository(Podcasts::class)
            ->find($request->get("id"));

            $commande->setTitle($request->get("Title"));
            $commande->setDescription($request->get("Description"));
            $commande->setRating($request->get("Rating"));
            $commande->setViews($request->get("Views"));
            $commande->setFile($request->get("File"));
            $commande->setImage($request->get("Image"));
            $idCategorie = $request->get("idCategorie");
            $commande->setIdcategorie($this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($idCategorie));

        try {
            $em->persist($commande);
            $em->flush();

            return new JsonResponse("Podcasts Modifie!", 200);
        }
        catch (\Exception $ex)
        {
            return new Response("Execption: ".$ex->getMessage());
        }

        //http://127.0.0.1:8000/ModifierPodcastsMobile?id=8&user=9&produit=6&quantite=10&adresse=ariana

    }
    /**
     * @Route("/DetailPodcastsMobile", name="DetailPodcastsMobile")
     */
    public function DetailPodcastsMobile(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Podcasts::class)->find($id);
        if($commande!=null ) {

            return $this->json($commande,200,[],['groups'=>'post:read']);

        }
        return new JsonResponse("ID Podcasts Invalide.");


    }  
}
