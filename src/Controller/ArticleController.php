<?php

namespace App\Controller;
use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\User;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Repository\CommentaireRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArticleType;
use App\Form\CommentaireType;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
     /**
     * @Route("/deletecom/{id}",name="deletecom",methods={"DELETE"})
     */
    public function deletecom(Request $request,Commentaire $comment)
    {
        if($this->isCsrfTokenValid('delete'.$comment->getId(),$request->request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front');
    }


    /**
     * @Route("/article/pdf", name="pdf1")
     */
    public function Liste(){
        $repository=$this->getDoctrine()->getRepository(Article::class);
        $pdfOptions = new Options();
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $article=$repository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('article/articlepdf.html.twig',
            ['articles'=>$article])

        ;

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Liste_articles.pdf", [
            'isRemoteEnabled' => true,
            "Attachment" => true
        ]);


    }
         /**
     * @Route("/deletecom2/{id}",name="deletecom2",methods={"DELETE"})
     */
    public function deletecom2(Request $request,Commentaire $comment)
    {
        if($this->isCsrfTokenValid('delete'.$comment->getId(),$request->request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        return $this->redirectToRoute('comment_index');
    }
    /**
     * @Route("/", name="reco_index", methods={"GET"})
     */
    public function index(): Response
    {
        $recos = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('article/index.html.twig', [
            'recos' => $recos,
        ]);
    }
  

     /**
     * @Route("/new", name="reco_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $Article = new Article();
        $form = $this->createForm(ArticleType::class, $Article);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $Article->setAuthorID(3);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Article);
            $entityManager->flush();

            return $this->redirectToRoute('reco_index');
        }

        return $this->render('article/new.html.twig', [
            'reco' => $Article,
            'form' => $form->createView(),
        ]);
    }
 /**
     * @Route("/{id}/edit", name="reco_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $reco): Response
    {
        $form = $this->createForm(ArticleType::class, $reco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reco_index');
        }

        return $this->render('article/edit.html.twig', [
            'reco' => $reco,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/commentedit", name="comment_edit", methods={"GET","POST"})
     */
    public function editcomment(Request $request, Commentaire $reco): Response
    {
        $form = $this->createForm(CommentaireType::class, $reco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front');
        }

        return $this->render('article/updatecomment.html.twig', [
            'reco' => $reco,
            'form' => $form->createView(),
        ]);
    }
   /**
           * @Route("/frontarticle", name="front")

     */

    public function front(PaginatorInterface $paginator,Request $request):Response
    {



        $recos = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();
        $recos = $paginator->paginate(
            $recos,
            $request->query->getInt('page',1),
            3);

        return $this->render('article/articlefront.html.twig', [
            'recos' => $recos,
        ]);
    }



    /**
     * @Route("/{id}", name="reco_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $reco): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reco->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reco);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reco_index');
    }
  /**
     * @Route("articlefront/{id}", name="reco_single", methods={"GET"})
     */
    public function showreco(Article $reco): Response
    {
        return $this->render('article/articlesingle.html.twig', [
            'reco' => $reco,
        ]);
    }
/**
     * @Route("/articletest/{id}", name="reco_single", methods={"GET","POST"})
     */
    public function reco_single(ArticleRepository $recoRepository,$id,Request $request,UserRepository $clientRepository,CommentaireRepository $commentRepository): Response
    {      

        $Recotype = $recoRepository->findBy(['id' => $id]);
        $comment = new Commentaire();
        $form = $this->createForm(CommentaireType::class,$comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();
            $val = $entityManager->getRepository(Article::class)->find($id);
            $userr = $entityManager->getRepository(User::class)->find(1);

            $comment->setSubmitDate(new \DateTime())
                ->setArticleID($val)
                ->setUserID($userr);
                //  ->setMessage($cleanString);

            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('reco_single',['id'=>$id]);
        }
        $recocomment = $commentRepository->findBy(['articleID'=>$id]);
        return $this->render('article/articlesingle.html.twig', [
            'recos' => $Recotype,
            'comments'=>$recocomment,
            'form'=>$form->createView(),
        ]);
    }


}
