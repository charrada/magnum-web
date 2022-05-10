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
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class TokenController extends AbstractController
{
	public function reset(
		Request $request,
		string $username,
		string $token
	): Response {
		$man = $this->getDoctrine()->getManager();
		$userRepo = $man->getRepository(Users::class);
		$tokenRepo = $man->getRepository(Tokens::class);

		$user = $userRepo->findOneBy(["username" => $username]);
        if (!$user) {
            return $this->redirectToRoute("generate_token");
        }

		$token = $tokenRepo->findOneBy(["user" => $user, "token" => $token]);
        if (!$token) {
            return $this->redirectToRoute("generate_token");
        }

		$form = $this->createForm(ResetWithTokenType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted()) {
			if (!$form->isValid()) {
                $this->addFlash('danger', 'The passwords you provided do not match, please try again.');
                return $this->render("token/reset.html.twig", [
                    "username" => $username,
                    "token" => $token,
                    "form" => $form->createView(),
                ]);
			}

            $data = new Users();
			$data = $form->getData();

			$hashedPassword = password_hash(
				$data->getPassword(),
				PASSWORD_DEFAULT
			);

			$user->setPassword($hashedPassword);
			$man->flush();

			return $this->redirectToRoute("app_login");
		}

		return $this->render("token/reset.html.twig", [
			"username" => $username,
			"token" => $token,
			"form" => $form->createView(),
		]);
	}

	public function input(Request $request, string $username): Response
	{
		$token = new Tokens();
		$form = $this->createForm(InputTokenType::class, $token);
		$form->handleRequest($request);
		$errors = [];

		if ($form->isSubmitted() && $form->isValid()) {
			$user = new Users();
			$token = $form->getData();
			$man = $this->getDoctrine()->getManager();
			$tokenRepo = $man->getRepository(Tokens::class);
			$userRepo = $man->getRepository(Users::class);

			$user = $userRepo->findOneBy(['username' => $username]);
			$token = $tokenRepo->findOneBy([
				"user" => $user,
				"token" => $token->getToken(),
			]);

			if (!$token) {
                $this->addFlash('danger', 'Not a valid token, please try again.');

				return $this->render("token/input.html.twig", [
					"username" => $username,
					"form" => $form->createView(),
				]);
			}

			if ($token->isConsumed()) {
                $this->addFlash('danger', 'This token has already been used before, please generate a new one.');
				return $this->render("token/input.html.twig", [
					"username" => $username,
					"form" => $form->createView(),
				]);
			}

			$token->setConsumed(true);
			$man->persist($token);
			$man->flush();

			return $this->redirectToRoute("reset_with_token", [
				"username" => $username,
				"token" => $token->getToken(),
			]);
		}

		return $this->render("token/input.html.twig", [
			"username" => $username,
			"form" => $form->createView(),
		]);
	}

	public function generate(Request $request, MailerInterface $mailer): Response
	{
		$user = new Users();
		$form = $this->createForm(GenerateTokenType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$user = $form->getData();
			$man = $this->getDoctrine()->getManager();
			$repo = $man->getRepository(Users::class);

			$user = $repo->findOneBy(['username' => $user->getUsername()]);
			if (!$user) {
				$this->addFlash(
					'danger',
					'We couldn\'t find anybody with that username, please try again.'
				);

				return $this->render("token/generate.html.twig", [
					"form" => $form->createView(),
				]);
			}

			$token = new Tokens();
			$token->setToken($this->random_str());
			$token->setConsumed(false);
			$token->setCreated(new DateTime("NOW"));
			$token->setUser($user);
			$man->persist($token);
			$man->flush();
			try {
				$email = (new TemplatedEmail())
				->from('devel.magnum@gmail.com')
				->to($user->getEmail())
				->subject('Reset your password')
				->htmlTemplate('email/password-token.html.twig')
                ->context([
                    'user' => $user,
                    'token' => $token,
                ]);
                $mailer->send($email);
			} catch (TransportExceptionInterface $e) {
				$this->addFlash(
					'danger',
					'We were unable to send you an email with your token, please try again.'
				);

				return $this->render("token/generate.html.twig", [
					"form" => $form->createView(),
				]);
			}

			return $this->redirectToRoute("input_token", [
				"username" => $user->getUsername(),
			]);
		}

		return $this->render("token/generate.html.twig", [
			"form" => $form->createView(),
		]);
	}

	function random_str(): string
	{
		$length = 128;

		if ($length < 1) {
			throw new \RangeException("Length must be a positive integer");
		}

		$pieces = [];
		$keyspace =
			"0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$max = mb_strlen($keyspace, "8bit") - 1;

		for ($i = 0; $i < $length; ++$i) {
			$pieces[] = $keyspace[random_int(0, $max)];
		}

		return implode("", $pieces);
	}
}
