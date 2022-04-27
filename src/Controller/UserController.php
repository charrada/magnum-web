<?php

namespace App\Controller;

use \Exception;
use \DateTime;
use App\Entity\Users;
use App\Entity\History;
use App\Entity\Administrators;
use App\Form\SecurityDetailsType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function getProfileTab(): Response {
        $user = $this->security->getUser();

        /* Set a placeholder avatar for users that don't have one. */
        if (is_null($user->getAvatar())) {
            $user->setAvatar('placeholder-avatar.svg');
        }

        return $this->render('user/tabs/profile/index.html.twig',
               [ 'user' => $user ]
        );
    }

    public function getRandomSuccessString(): string {
        $success_messages = array('Woohoo! ', 'Awesome! ', 'Nice! ');
        $index = array_rand($success_messages, 1);
        $msg = $success_messages[$index];
        return $msg;
    }

    public function getSecurityTab(Request $request): Response {
        $user = new Users();
        $form = $this->createForm(SecurityDetailsType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
			if (!$form->isValid()) {
                $this->addFlash('danger', 'The passwords you provided do not match, please try again.');
                return $this->render("user/tabs/security/index.html.twig", [
                    'form' => $form->createView()
                ]);
			}

            try {
                $this->resetSecurityDetails($form);
                $this->addFlash(
                    'success',
                    $this->getRandomSuccessString() . 'Your password has been successfully reset!'
                );
            } catch (CurrentPasswordException $e) {
                $this->addFlash('danger', $e->getMessage());
            }
        }

        return $this->render("user/tabs/security/index.html.twig", [
            'form' => $form->createView()
        ]);
    }

    public function resetSecurityDetails($user_form): void {
        $man = $this->getDoctrine()->getManager();
        $user_repo = $man->getRepository(Users::class);
        $user = $this->security->getUser();

        $data = new Users();
        $data = $user_form->getData();

        /* Fail if the current password hash does not match the user's password */
        if (!password_verify($data->getPassword(), $user->getPassword())) {
            throw new CurrentPasswordException('The current password field does not match your actual password.');
        }

        $hashed_pw = password_hash($data->getPassword(), PASSWORD_BCRYPT);
        $user->setPassword($hashed_pw);
        $man->persist($user);
        $man->flush();

        $this->forward('App\Controller\HistoryController::addToHistory', [
            'user' => $user,
            'activity'  => 'Security',
            'description' => 'You reset your password.',
        ]);
    }
}

class CurrentPasswordException extends Exception {}
