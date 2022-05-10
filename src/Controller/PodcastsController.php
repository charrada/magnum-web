<?php

namespace App\Controller;

use App\Entity\Podcasts;
use App\Entity\Categorie;

use App\Form\PodcastsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Dompdf\Dompdf;
use Dompdf\Options;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Repository\PodcastsRepository;
use App\Services\QrcodeService;
/**
 * @Route("/podcasts")
 */
class PodcastsController extends AbstractController
{
    /**
     * @Route("/", name="app_podcasts_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request,FlashyNotifier $flashy): Response
    {
        $podcasts = $entityManager
            ->getRepository(Podcasts::class)
            ->findAll();
            $flashy->primaryDark('notif!', 'http://your-awesome-link.com');

       $podcasts = $paginator->paginate(
            $podcasts, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2/*limit per page*/
        );

        return $this->render('podcasts/index.html.twig', [
            'podcasts' => $podcasts,
        ]);
    }











    /**
     * @Route("/front", name="app_podcasts_indexfront", methods={"GET"})
     */
    public function indexfront(EntityManagerInterface $entityManager, Request $request,FlashyNotifier $flashy,QrcodeService $qrcodeService): Response
    {
        $podcasts = $entityManager
            ->getRepository(Podcasts::class)
            ->findAll();
            $flashy->primaryDark('notif!', 'http://your-awesome-link.com');

                $qrCode = null;

                $data = "";
                $qrCode = $qrcodeService->qrcode($data);

        return $this->render('podcasts/indexfront.html.twig', [
            'podcasts' => $podcasts,
            'qrCode' => $qrCode
        ]);
    }


























    /**
     * @Route("/new", name="app_podcasts_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {



        $podcast = new Podcasts();
        $form = $this->createForm(PodcastsType::class, $podcast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('podcasts')['image'];
            $file2 = $request->files->get('podcasts')['file'];
            // $file=$Podcasts->getImagePodcasts();
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $filename2 = md5(uniqid()) . '.' . $file2->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $file2->move(
                $uploads_directory,
                $filename2
            );
            $podcast->setImage($filename);
            $podcast->setFile($filename2);
            $entityManager->persist($podcast);
            $entityManager->flush();

            return $this->redirectToRoute('app_podcasts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('podcasts/new.html.twig', [
            'podcast' => $podcast,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="app_podcasts_show", methods={"GET"})
     */
    public function show(Podcasts $podcast): Response
    {
        return $this->render('podcasts/show.html.twig', [
            'podcast' => $podcast,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_podcasts_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Podcasts $podcast, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PodcastsType::class, $podcast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_podcasts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('podcasts/edit.html.twig', [
            'podcast' => $podcast,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_podcasts_delete", methods={"POST"})
     */
    public function delete(Request $request, Podcasts $podcast, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $podcast->getId(), $request->request->get('_token'))) {
            $entityManager->remove($podcast);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_podcasts_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/statrate", name="statrate")
     */
    public function stat()
    {

        $repository = $this->getDoctrine()->getRepository(Podcasts::class);
        $podcast = $repository->findAll();

        $em = $this->getDoctrine()->getManager();


        $pr1 = 0;
        $pr2 = 0;



        foreach ($podcast as $podcast) {
            if ($podcast->getRating() >= "0") :

                $pr1 += 1;
            else :

                $pr2 += 1;


            endif;
        }

        $pieChart = new PieChart();
         $pieChart->getData()->setArrayToDataTable(
            [
                ['rating', 'title'],
                ['les voyages qui ont prix sup à 1500', $pr1],
                ['les voyages qui ont prix inf à 1500', $pr2],

            ]
        );
        $pieChart->getOptions()->setTitle('Prix des voyages');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('podcasts/statpodcasts.html.twig', array('piechart' => $pieChart));
    }
    /**
     * @Route("/Recherchepod", name="Recherchepod")
     */
    public function rechercheByName(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $podcast=$em->getRepository(Podcasts::class)->findAll();
        if($request->isMethod("POST"))
        {
            $Title = $request->get('title');
            $podcast=$em->getRepository(Podcasts::class)->findBy(array('title'=>$Title));
        }
        return $this->render('podcasts/index.html.twig', array('podcasts' => $podcast));
        //    return $this->redirectToRoute('Recherche',array('m' => $maison));


    }
    /**
     * @Route("/test/imprimresv", name="imprimresv2")
     */
    public function imprimresv()
    {
        $repository=$this->getDoctrine()->getRepository(Podcasts::class);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('defaultFont', 'Arial');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $podcasts = $repository->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('podcasts/imprimerpod.html.twig', [
            'podcasts' => $podcasts,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Liste_Podcasts.pdf", [
            'isRemoteEnabled' => true,
            "Attachment" => true        ]);
    }



    /**
     * @Route("/s/searchpodcast", name="searchPodcast")
     */
    public function searchPodcast(Request $request,NormalizerInterface $Normalizer,PodcastsRepository $repository):Response
    {
        $requestString=$request->get('searchValue');
        $Categorie = $repository->findByNom($requestString);
        $jsonContent = $Normalizer->normalize($Categorie, 'json',['Groups'=>'Podcasts:read']);
        $retour =json_encode($jsonContent);
        return new Response($retour);

    }



  


    /**
     * @Route("/new/statistique", name="Podcasts_stats")
     */

    public function statistiques(Request $request , PodcastsRepository $PodcastsRep){
        $Podcasts= [];
        $Podcasts= $this->getDoctrine()->getRepository(Podcasts::class)->findAll();
        $Categorie= $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        $categNom=[];
        $Podcastscount=[];   
  

        $checker=[];
      
        foreach($Podcasts as $Podcasts){

            if(in_array( $Podcasts->getIdcategorie() , $checker) ){
               
            }else{
                $checker[]=$Podcasts->getIdcategorie();
            $Podcastsx=$PodcastsRep->countbyCategorie($Podcasts->getIdcategorie());

          $categNom[]= $Podcasts->getIdcategorie()->getNamecateg(); 
           $Podcastscount[]= $Podcastsx[0]['count'];
                
            }

        }
        return $this->render('podcasts/podcastStats.html.twig',[
            'categNom'=>json_encode($categNom),
            'rolescount'=>json_encode($Podcastscount),
    
          ]);
      }









}
