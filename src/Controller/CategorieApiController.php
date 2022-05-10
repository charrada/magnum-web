<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;


class CategorieApiController extends AbstractController
{
    /**
     * @Route("/AfficherCategorieMobile", name="AfficherCategorieMobile")
     */
    public function AfficherCategorieMobile(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository(Categorie::class)->findAll();

        return $this->json($commandes,200,[],['groups'=>'post:read']);

        //http://127.0.0.1:8000/AfficherCategorieMobile

    }
    /**
     * @Route("/SupprimerCategorieMobile", name="SupprimerCategorieMobile")
     */
    public function SupprimerCategorieMobile(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Categorie::class)->find($id);
        if($commande!=null ) {
            $em->remove($commande);
            $em->flush();

            return new JsonResponse("Categorie Supprime!", 200);
        }
        return new JsonResponse("ID Categorie Invalide.");


    }
    /**
     * @Route("/AjouterCategorieMobile", name="AjouterCategorieMobile")
     */
    public function AjouterCategorieMobile(Request $request)
    {
        $commande = new Categorie();
        $commande->setNamecateg($request->get("namecateg"));
        $commande->setDescriptioncateg($request->get("Descriptioncateg"));
        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return new JsonResponse("Categorie Ajoute!", 200);
        }
        catch (\Exception $ex)
        {
            return new Response("Execption: ".$ex->getMessage());
        }

        //http://127.0.0.1:8000/AjouterCategorieMobile?user=9&produit=6&quantite=5&adresse=bouzid


    }
    /**
     * @Route("/ModifierCategorieMobile", name="ModifierCategorieMobile")
     */
    public function ModifierCategorieMobile(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $this->getDoctrine()->getManager()
            ->getRepository(Categorie::class)
            ->find($request->get("id"));

        $commande->setNamecateg($request->get("namecateg"));
        $commande->setDescriptioncateg($request->get("Descriptioncateg"));

        try {
            $em->persist($commande);
            $em->flush();

            return new JsonResponse("Categorie Modifie!", 200);
        }
        catch (\Exception $ex)
        {
            return new Response("Execption: ".$ex->getMessage());
        }

        //http://127.0.0.1:8000/ModifierCategorieMobile?id=8&user=9&produit=6&quantite=10&adresse=ariana

    }
    /**
     * @Route("/DetailCategorieMobile", name="DetailCategorieMobile")
     */
    public function DetailCategorieMobile(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Categorie::class)->find($id);
        if($commande!=null ) {

            return $this->json($commande,200,[],['groups'=>'post:read']);

        }
        return new JsonResponse("ID Categorie Invalide.");


    }                  
}
