<?php

namespace App\Controller;

use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Validator\Constraints\Json;
class TicketApiController extends AbstractController
{
    /**
     * @Route("/ticket/api", name="app_ticket_api")
     */
    public function index(): Response
    {
        return $this->render('ticket_api/index.html.twig', [
            'controller_name' => 'TicketApiController',
        ]);
    }



    /**
     * @Route("/AjouterTicketMobile", name="AjouterTicketMobile")
     */
    public function AjouterTicketMobile(Request $request)
    {
        $Ticket = new Ticket();
        $Ticket->setid($request->get("id"));
        $Ticket->setuserid($request->get("userid"));
        $Ticket->setsubject($request->get("subject"));
        $Ticket->setdescription($request->get("description"));
        $Ticket->setresolverid($request->get("resolverid"));
        $Ticket->setstatus($request->get("status"));

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Ticket);
            $em->flush();

            return new JsonResponse("Ticket Ajouter!", 200);
        }
        catch (\Exception $ex)
        {
            return new Response("Execption: ".$ex->getMessage());
        }
   //http://127.0.0.1:8000/AjouterTicketMobile?id=955&userid=944&subject=test&description=test&status=Pending&resolverid=


    }



    /**
     * @Route("/SupprimerTicketMobile", name="SupprimerTicketMobile")
     */
    public function SupprimerTicketMobile(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $Ticket = $em->getRepository(Ticket::class)->find($id);
        if($Ticket!=null ) {
            $em->remove($Ticket);
            $em->flush();

            return new JsonResponse("Ticket Supprimer!", 200);
        }
        return new JsonResponse("Ticket Invalide.");

        //http://127.0.0.1:8000/SupprimerTicketMobile?id=948
    }



       /**
     * @Route("/AfficherTicketMobile", name="AfficherTicketMobile")
     */
    public function AfficherTicketMobile(Request $request)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $Ticket = $em->getRepository(Ticket::class)->findBy(["id" => $em->getRepository(Ticket::class)->find($id)]);

        return $this->json($Ticket,200,[],['groups'=>'post:read']);

        //http://127.0.0.1:8000/AfficherTicketMobile?id=978

    }


     /**
     * @Route("/AfficherAllTicketMobile", name="AfficherAllTicketMobile")
     */
    public function AfficherAllTicketMobile()
    {

        $em = $this->getDoctrine()->getManager();
        $Ticket = $em->getRepository(Ticket::class)->findAll();

        return $this->json($Ticket,200,[],['groups'=>'post:read']);

        //http://127.0.0.1:8000/AfficherAllTicketMobile

    }





     /**
     * @Route("/ModifierStatusTicketMobile", name="ModifierStatusTicketMobile")
     */
    public function ModifierStatusTicketMobile(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Ticket = $this->getDoctrine()->getManager()
            ->getRepository(Ticket::class)
            ->find($request->get("id"));

        

        $Ticket->setstatus($request->get("status"));

        try {
            $em->persist($Ticket);
            $em->flush();

            return new JsonResponse("Status ticket Modifier!", 200);
        }
        catch (\Exception $ex)
        {
            return new Response("Execption: ".$ex->getMessage());
        }

        //http://127.0.0.1:8000/ModifierStatusTicketMobile?id=978&status=Resolved

    }



       /**
     * @Route("/ModifierEvaluateTicketMobile", name="ModifierEvaluateTicketMobile")
     */
    public function ModifierEvaluateTicketMobile(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Ticket = $this->getDoctrine()->getManager()
            ->getRepository(Ticket::class)
            ->find($request->get("id"));

        

        $Ticket->setevaluate($request->get("evaluate"));

        try {
            $em->persist($Ticket);
            $em->flush();

            return new JsonResponse("Evaluate ticket Modifier!", 200);
        }
        catch (\Exception $ex)
        {
            return new Response("Execption: ".$ex->getMessage());
        }

        //http://127.0.0.1:8000/ModifierEvaluateTicketMobile?id=978&evaluate=5

    }


}
