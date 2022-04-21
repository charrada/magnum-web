<?php

namespace App\Controller;

use \DateTime;
use App\Entity\Users;
use App\Entity\History;
use App\Form\SecurityDetailsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    public function getProfile(): Response
    {
        return $this->render('user/tabs/profile/index.html.twig', []);
    }

    public function resetSecurityDetails(Request $request): Response {
        $success_messages = array('Woohoo!', 'Awesome!', 'Nice!');
        $man = $this->getDoctrine()->getManager();
        $user_repo = $man->getRepository(Users::class);
        $user_form = new Users();

        $form = $this->createForm(SecurityDetailsType::class, $user_form);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->security->getUser();
            $user_form = $form->getData();

            /* Fail if the current password hash does not match the user's password */
            if (!password_verify($user_form->getPassword(), $user->getPassword())) {
                $this->addFlash(
                    'danger',
                    'The current password field does not match your actual password.'
                );

                return $this->render("user/tabs/security/index.html.twig", [
                    'form' => $form->createView()
                ]);
            }

            /* Check if the new password and its confirmation are a match */
            if ($user_form->getNewPassword() != $user_form->getPasswordConfirm()) {
                $this->addFlash(
                    'danger',
                    'The new password does not match the confirmation password.'
                );

                return $this->render("user/tabs/security/index.html.twig", [
                    'form' => $form->createView()
                ]);
            }

            $rand = array_rand($success_messages, 1);
            $this->addFlash(
                'success',
                $success_messages[$rand] . ' Your password has been successfully reset!'
            );

            $hashed_pw = password_hash($user_form->getNewPassword(), PASSWORD_BCRYPT);
            $user->setPassword($hashed_pw);
            $man->persist($user);
            $man->flush();

            $this->addToHistory('Security', 'You reset your password.', $user);

            return $this->render("user/tabs/security/index.html.twig", [
                'form' => $form->createView()
            ]);
        }
        
        return $this->render('user/tabs/security/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function getHistory(): Response {
        $man = $this->getDoctrine()->getManager();
        $user_repo = $man->getRepository(Users::class);
        $hist_repo = $man->getRepository(History::class);
        $session_user = $this->security->getUser();

        $user = new Users();
        $history = new History();

        $user = $user_repo->findOneBy(['username' => $session_user->getUsername()]);
        $history = $hist_repo->findBy(['user' => $session_user]);

        return $this->render('user/tabs/history/index.html.twig', [
            'history' => $history,
        ]);
    }

    public function addToHistory($activity, $description, $user): void {
        $man = $this->getDoctrine()->getManager();
        $hist_repo = $man->getRepository(History::class);
        $time = new DateTime();
        $hist = new History();

        $hist->setDescription($description);
        $hist->setActivity($activity);
        $hist->setUser($user);
        $hist->setTime($time);

        $man->persist($hist);
        $man->flush();

        return;
    }
}
