<?php

namespace App\Controller;

use \Exception;
use \DateTime;
use App\Entity\Users;
use App\Entity\History;
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
        return $this->render('user/tabs/profile/index.html.twig', []);
    }

    public function getRandomSuccessString(): string {
        $success_messages = array('Woohoo!', 'Awesome!', 'Nice!');
        $index = array_rand($success_messages, 1);
        $msg = $success_messages[$index];
        return $msg;
    }

    public function getSecurityTab(Request $request): Response {
        $user = new Users();
        $form = $this->createForm(SecurityDetailsType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->resetSecurityDetails($user);

                $this->addFlash(
                    'success',
                    $this->getRandomSuccessString() . ' Your password has been successfully reset!'
                );
            } catch (CurrentPasswordException $e) {
                $this->addFlash('danger', $e->getMessage());
            } catch (PasswordMatchException $e) {
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

        /* Fail if the current password hash does not match the user's password */
        if (!password_verify($user_form->getPassword(), $user->getPassword())) {
            throw new CurrentPasswordException('The current password field does not match your actual password.');
        }

        /* Check if the new password and its confirmation are a match */
        if ($user_form->getNewPassword() != $user_form->getPasswordConfirm()) {
            throw new PasswordMatchException('The new password does not match the confirmation password.');
        }

        $hashed_pw = password_hash($user_form->getNewPassword(), PASSWORD_BCRYPT);
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

class PasswordMatchException extends Exception {}
class CurrentPasswordException extends Exception {}
