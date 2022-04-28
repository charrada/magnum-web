<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\History;
use App\Form\BackendEditUserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

class BackendController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('backend/index.html.twig', []);
    }

    public function getUserInformation(): Response
    {
        $man = $this->getDoctrine()->getManager();
        $repo = $man->getRepository(Users::class);
        $users = $repo->findBy([], [], 100, 0);

        return $this->render('backend/users/info.html.twig', [
            'users' => $users
        ]);
    }

    public function manageUser(Request $request, string $username): Response
    {
        $man = $this->getDoctrine()->getManager();
        $repo = $man->getRepository(Users::class);
        $user = new Users();
        $user = $repo->findOneBy(['username' => $username]);

        $form = $this->createForm(BackendEditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $man->persist($user);
            $man->flush();

            return $this->redirectToRoute('backend_user_information');
        }

        return $this->render('backend/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    public function getUserHistory(string $username): Response
    {
        $man = $this->getDoctrine()->getManager();
        $user_repo = $man->getRepository(Users::class);
        $hist_repo = $man->getRepository(History::class);

        $user = new Users();
        $user = $user_repo->findOneBy(['username' => $username]);
        $history = $hist_repo->findBy(['user' => $user]);

        return $this->render('backend/users/history.html.twig', [
            'history' => $history,
        ]);
    }

    public function getUserFlags(string $username): Response
    {
        return $this->render('backend/users/flags.html.twig', []);
    }
}
