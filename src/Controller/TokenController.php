<?php

namespace App\Controller;

use \DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\GenerateTokenType;
use App\Form\ResetWithTokenType;
use App\Form\InputTokenType;
use App\Entity\Tokens;
use App\Entity\Users;

class TokenController extends AbstractController
{

    private function bounceUnauthorized(object $_o = null) {
         if (!$_o) {
             return $this->redirectToRoute('generate_token');
         } 
    }

    public function reset(Request $request, string $username, string $token): Response
    {
        $man = $this->getDoctrine()->getManager();
        $userRepo = $man->getRepository(Users::class);
        $tokenRepo = $man->getRepository(Tokens::class);

        $_user = $userRepo->findOneBy(['username' => $username]);
        $this->bounceUnauthorized($_user);

        $_token = $tokenRepo->findOneBy(['user' => $_user, 'token' => $token]);
        $this->bounceUnauthorized($_token);

        $form = $this->createForm(ResetWithTokenType::class, $_user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $_data = $form->getData();

            if ($_data->getPassword() != $_data->getPasswordConfirm()) {
               $errors[] = array('message' => 'The passwords you provided do not match, please try again.');
               return $this->render('token/reset.html.twig', [ 'errors' => $errors ]);
            }
            
            $hashedPassword = password_hash($_data->getPassword(), PASSWORD_DEFAULT);
            $_user->setPassword($hashedPassword);
            $man->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('token/reset.html.twig', [
            'username' => $username,
            'token' => $token,
            'form' => $form->createView(),
            'errors' => array(), 
        ]);
    }

    public function input(Request $request, string $username): Response
    {
        $token = new Tokens();
        $form = $this->createForm(InputTokenType::class, $token);
        $form->handleRequest($request);
        $errors = array();

        if ($form->isSubmitted() && $form->isValid()) {
          $token = $form->getData();
          $man = $this->getDoctrine()->getManager();
          $tokenRepo = $man->getRepository(Tokens::class);
          $userRepo = $man->getRepository(Users::class);

          $user = $userRepo->findOneBy(['username' => $username]);
          $token = $tokenRepo->findOneBy(['user' => current($user), 'token' => $token->getToken()]);

          if (!$token) {
             $errors[] = array('message' => 'Not a valid token, please try again.');
             return $this->render('token/input.html.twig', [
               'username' => $username,
               'form' => $form->createView(),
               'errors' => $errors,
             ]);
          }

          if ($token->isConsumed()) {
             $errors[] = array('message' => 'Token has already been used before, please generate a new one.');
             return $this->render('token/input.html.twig', [
               'username' => $username,
               'form' => $form->createView(),
               'errors' => $errors,
             ]);
          }

          $token->setConsumed(true);
          $man->persist($token);
          $man->flush();

          return $this->redirectToRoute('reset_with_token', [
            'username' => $username,
            'token' => $token->getToken(),
          ]);
        }

        return $this->render('token/input.html.twig', [
            'username' => $username,
            'form' => $form->createView(),
            'errors' => array(), 
        ]);
    }

    public function generate(Request $request): Response
    {
        $user = new Users();
        $form = $this->createForm(GenerateTokenType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $man = $this->getDoctrine()->getManager();
            $repo = $man->getRepository(Users::class);
            $errors = array();

            $user = $repo->findMatchingUsers($user);
            if (!$user) {
               $errors[] = array('message' => 'We couldn\'t find anybody with that username, please try again.');
               return $this->render('token/generate.html.twig', [
                 'form' => $form->createView(),
                 'errors' => $errors,
               ]);
            }

            $token = new Tokens();
            $token->setToken($this->random_str());
            $token->setConsumed(false);
            $token->setCreated(new DateTime('NOW'));
            $token->setUser(current($user));

            $man->persist($token);
            $man->flush();

            return $this->redirectToRoute('input_token', ['username' => current($user)->getUsername()]);
        }

        return $this->render('token/generate.html.twig', [
            'form' => $form->createView(),
            'errors' => array(), 
        ]);
    }

    function random_str(): string {
        $length = 128;

        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }

        $pieces = [];
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = mb_strlen($keyspace, '8bit') - 1;

        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }

        return implode('', $pieces);
    }
}
