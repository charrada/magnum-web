<?php

namespace App\Controller;
use App\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\CommentaireType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="app_commentaire")
     */
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }
  /**
     * @Route("/", name="comment_index", methods={"GET"})
     */
    public function commentindex(): Response
    {
        $comments = $this->getDoctrine()
            ->getRepository(Commentaire::class)
            ->findAll();

        return $this->render('commentaire/index.html.twig', [
            'comments' => $comments,
        ]);
    }
    /**
    * @param Request $request
    * @return \Symfony\Component\HttpFoundation\Response;
    * @Route("Commentaire/addComment", name="addComment")
    */
    public function addCommentaire(Request $request)
    {
       $Commentaire=new Commentaire();
        $form=$this->createForm(CommentaireType::class,$Commentaire);
        $form->add('add', SubmitType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($Commentaire);
            $em->flush();

            return $this->redirectToRoute('app_commentaire');
        }
        else
        return $this->render('commentaire/createcommentaire.html.twig',['f'=>$form->createView()]);

        
    }
}


