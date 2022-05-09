<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    public function register(Request $request): Response
    {
        $user = new Users();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $man = $this->getDoctrine()->getManager();
            $repo = $man->getRepository(Users::class);
            $errors = [];

            if ($repo->findMatchingUsers($user)) {
                $errors[] = [
                    "message" =>
                        "A user with the same username/email exists within our records",
                ];
                return $this->redirectToRoute("app_home", [
                    "form" => $form->createView(),
                    "errors" => $errors,
                ]);
            }

            $avatarFile = $form->get("avatar")->getData();

            if ($avatarFile) {
                $originalFilename = pathinfo(
                    $avatarFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $safeFilename = transliterator_transliterate(
                    "Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()",
                    $originalFilename
                );
                $newFilename =
                    $safeFilename .
                    "-" .
                    uniqid() .
                    "." .
                    $avatarFile->guessExtension();

                try {
                    // Move the file to the directory where avatars are stored
                    $avatarFile->move(
                        $this->getParameter("avatar_directory"),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $user->setAvatar($newFilename);
            }

            $hashedPassword = password_hash(
                $user->getPassword(),
                PASSWORD_DEFAULT
            );
            $user->setPassword($hashedPassword);
            $user->setStatus("Active");
            $man->persist($user);
            $man->flush();

            return $this->redirectToRoute("app_login");
        }

        return $this->render("register/index.html.twig", [
            "form" => $form->createView(),
            "errors" => [],
        ]);
    }
}
