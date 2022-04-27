<?php

namespace App\Controller;

use App\Entity\Podcasts;
use App\Form\PodcastsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/podcasts")
 */
class PodcastsController extends AbstractController
{
    /**
     * @Route("/", name="app_podcasts_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $podcasts = $entityManager
            ->getRepository(Podcasts::class)
            ->findAll();

        return $this->render('podcasts/index.html.twig', [
            'podcasts' => $podcasts,
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
           // $file=$jeux->getImagejeux();
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename=md5(uniqid()) . '.' . $file->guessExtension();
            $filename2=md5(uniqid()) . '.' . $file2->guessExtension();
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
        if ($this->isCsrfTokenValid('delete'.$podcast->getId(), $request->request->get('_token'))) {
            $entityManager->remove($podcast);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_podcasts_index', [], Response::HTTP_SEE_OTHER);
    }
}
