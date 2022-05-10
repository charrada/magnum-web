<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Ticket;
use App\Entity\Ticketkind;
use App\Entity\Tickettype;
use App\Form\ResolverType;
use App\Repository\TicketRepository;
use function PHPUnit\Framework\isNull;
use App\Repository\TicketkindRepository;
use App\Repository\TickettypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResolverController extends AbstractController
{
    /**
     * @Route("/resolver/", name="resolver")
     */
    public function index(): Response
    {
        $t = new Ticket();
        $form = $this->createForm(ResolverType::class, $t);


        $ticket = $this->getDoctrine()->getManager()->getRepository(Ticket::class)->findAll();
        $typ = $this->getDoctrine()->getManager()->getRepository(Tickettype::class)->findAll();
        $kind = $this->getDoctrine()->getManager()->getRepository(Ticketkind::class)->findAll();
        return $this->render('resolver/index.html.twig', ['t' => $ticket, 'typ' => $typ,'k' => $kind]);
    }
        /**
     * @Route("/stat", name="stat")
     */
    public function stat()
    {

        $repository = $this->getDoctrine()->getRepository(Ticket::class);
        $ticket = $repository->findAll();

        $em = $this->getDoctrine()->getManager();


        $pr1 = 0;
        $pr2 = 0;



        foreach ($ticket as $ticket) {
            if ($ticket->getevaluate() >= "3") :

                $pr1 += 1;
            else :

                $pr2 += 1;


            endif;
        }

        $pieChart = new PieChart();
         $pieChart->getData()->setArrayToDataTable(
            [
                ['Evaluate', 'subject'],
                ['Evaluation More ⇧ Than 2 stars', $pr1],
                ['Evaluation Less ⇩ Than 2 stars', $pr2],

            ]
        );
        $pieChart->getOptions()->setTitle('Statistics Of Evaluations 📈');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('resolver/statres.html.twig', array('piechart' => $pieChart));
    }



    /**
     * @Route("listpdf", name="imprime")
     */
    public function imprimresv()
    {
        $repository = $this->getDoctrine()->getRepository(Ticket::class);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('defaultFont', 'Arial');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $ticket = $repository->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('resolver/listpdf.html.twig', [
            't' => $ticket,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Liste_Tickets.pdf", [
            'isRemoteEnabled' => true,
            "Attachment" => true
        ]);
    }



    /**
     * @Route("/resolver/supp/{id}", name="d")
     */
    public function Delete($id, TicketRepository $rep, TicketkindRepository $rep2): Response
    {
        $ticket = $rep->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($ticket);
        $em->flush();

        $kind = $rep2->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($kind);
        $em->flush();

        return $this->redirectToRoute('resolver');
    }

    /**
     * @Route("/resolver/update/resolved/{id}", name="resolved")
     */
    public function updateR($id, TicketRepository $rep): Response
    {
        $ticket = $rep->find($id);
        $ticket->setstatus("Resolved");
        //taha aziz
        $ticket->setresolverid("1");
        // $ticket->setresolverid($res);
        $em = $this->getDoctrine()->getManager();

        $em->flush();
        return $this->redirectToRoute('resolver');
    }

    /**
     * @Route("/resolver/update/pending/{id}", name="pending")
     */
    public function updateP($id, TicketRepository $rep): Response
    {
        $ticket = $rep->find($id);
        $ticket->setstatus("Pending");
        $ticket->setresolverid("1");
        $em = $this->getDoctrine()->getManager();

        $em->flush();
        return $this->redirectToRoute('resolver');
    }

      /**
     * @Route("/resolver/update/closed/{id}", name="closed")
     */
    public function updateC($id, TicketRepository $rep): Response
    {
        $ticket = $rep->find($id);
        $ticket->setstatus("Closed");
        $ticket->setresolverid("1");
        $em = $this->getDoctrine()->getManager();

        $em->flush();
        return $this->redirectToRoute('resolver');
    }

    /**
     * @Route("/resolver/search/", name="rech")
     */
    public function search(TicketRepository $rep, Request $req): Response
    {
        $data = $req->get('rech');
        if ($data == '') {
            $t = new Ticket();
            $form = $this->createForm(ResolverType::class, $t);

            $ticket = $this->getDoctrine()->getManager()->getRepository(Ticket::class)->findAll();
            $typ = $this->getDoctrine()->getManager()->getRepository(Tickettype::class)->findAll();
            $kind = $this->getDoctrine()->getManager()->getRepository(Ticketkind::class)->findAll();
            return $this->render('resolver/index.html.twig', [
                't' => $ticket, 'typ' => $typ,'k' => $kind
            ]);
        } else {
            $typ = $this->getDoctrine()->getManager()->getRepository(Tickettype::class)->findAll();
            $ticket = $rep->findBy(['id' => $data]);
            $kind = $this->getDoctrine()->getManager()->getRepository(Ticketkind::class)->findAll();

            return $this->render('resolver/index.html.twig', ['t' => $ticket, 'typ' => $typ,'k' => $kind]);
        }
    }


    /**
     * @Route("/resolver/type/", name="addType")
     */
    public function addType(Request $req): Response
    {

        $t = new Tickettype;
        $data = $req->get('type');
        if ($data != '') {
            $t->settype($data);
            $em = $this->getDoctrine()->getManager();
            $em->persist($t);
            $em->flush();
            return $this->redirectToRoute('resolver');
        }
    }



    /**
     * @Route("/resolver/suppt/{tp}", name="dt")
     */
    public function DeleteT($tp, TickettypeRepository $rep, TicketkindRepository $rep2, TicketRepository $rep3): Response
    {

        $t1 = new Ticketkind;
        $t2 = new Ticketkind;
        $t3 = new Ticket;



        $t1 = $rep2->findBy(['itype' => $tp]);




        foreach ($t1 as &$value) {
            $t3 = $rep3->find($value->getid());
            // $t2=$rep2->find($value->getid());

            $em = $this->getDoctrine()->getManager();
            $em->remove($t3);
            $em->flush();
        }




        $t4 = $rep->find($tp);
        $em3 = $this->getDoctrine()->getManager();
        $em3->remove($t4);
        $em3->flush();








        return $this->redirectToRoute('resolver');
    }







    /**
     * @Route("/chat/reply/", name="reply")
     */
    public function reply(): Response
    {
        return $this->render('reply/index.html.twig', [
            'controller_name' => 'ChoixController',
        ]);
    }
}
