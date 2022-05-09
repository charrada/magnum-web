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
        $success_messages = array('Woohoo! ', 'Nice! ');
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
    
    public function fetchHistoryByType(string $activity) {
        $user = new Users();
        $man = $this->getDoctrine()->getManager();
        $user_repo = $man->getRepository(Users::class);
        $hist_repo = $man->getRepository(History::class);
        $curr_user = $this->security->getUser();

        $user = $user_repo->findOneBy(['username' => $curr_user->getUsername()]);
        $history = $hist_repo->findBy(['user' => $curr_user, 'activity' => $activity]);

        return $history;
    }

    public function eraseHistory(): void {
        $user = $this->security->getUser();
        $man  = $this->getDoctrine()->getManager();
        $man->getRepository(History::class)->erase($user);
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
        $history = $this->fetchHistory();
        $form = $this->createForm(HistoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $button = $form->getClickedButton()->getName();
            if ($form->getClickedButton() && $button === 'clear') {
                $this->eraseHistory();

                $this->addFlash(
                    'success',
                    $this->getRandomSuccessString() . 'You cleared your history.'
                );
            } else if ($form->getClickedButton() && $button == 'filter') {
                $_hist = $form->getData();

                if ($_hist->getActivity() != 'All') {
                    $history = $this->fetchHistoryByType($_hist->getActivity());
                }
            }
        }

        if (sizeof($history) == 0) {
            $this->addFlash(
                'warning',
                'You currently have no history of this kind.'
            );
        }

        return $this->render('user/tabs/history/index.html.twig', [
            'form' => $form->createView(),
            'history' => $history,
        ]);
    }
}
