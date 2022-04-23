<?php

namespace App\Controller;

use \DateTime;
use App\Entity\Users;
use App\Entity\History;
use App\Form\HistoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HistoryController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    public function getRandomSuccessString(): string {
        $success_messages = array('Woohoo!', 'Awesome!', 'Nice!');
        $index = array_rand($success_messages, 1);
        $msg = $success_messages[$index];
        return $msg;
    }

    public function fetchHistory() {
        $user = new Users();
        $man = $this->getDoctrine()->getManager();
        $user_repo = $man->getRepository(Users::class);
        $hist_repo = $man->getRepository(History::class);
        $curr_user = $this->security->getUser();

        $user = $user_repo->findOneBy(['username' => $curr_user->getUsername()]);
        $history = $hist_repo->findBy(['user' => $curr_user]);

        return $history;
    }

    public function clearHistory(): void {
        $man  = $this->getDoctrine()->getManager();
        $repo = $man->getRepository(History::class);
        $user = $this->security->getUser();
        $repo->clearHistory($user);
        return;
    }

    public function addToHistory(
        string $activity,
        string $description,
        Users $user
    ): void {
        $man = $this->getDoctrine()->getManager();

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

    public function getHistoryTab(Request $request): Response {
        $form = $this->createForm(HistoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() && 'clear' === $form->getClickedButton()->getName()) {
                $this->clearHistory();

                $this->addFlash(
                    'success',
                    $this->getRandomSuccessString() . 'You\'ve cleared all your history'
                );
            }
        }

        return $this->render('user/tabs/history/index.html.twig', [
            'form' => $form->createView(),
            'history' => $this->getHistory(),
        ]);
    }
}
