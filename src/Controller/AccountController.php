<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/user', name: 'app_account')]
    public function Account(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_candidat_account');
        }
        else  {
            return $this->redirectToRoute('app_recruteur_account');
        }


    }

    #[Route('/user/compte', name: 'app_user_account')]
    public function userAccount(): Response
    {
        return $this->render('home/account.html.twig');
    }

    #[Route('/candidat/compte', name: 'app_candidat_account')]
    public function candidat(): Response
    {

        return $this->render('account/candidat.html.twig');
    }

    #[Route('/recruteur/compte', name: 'app_recruteur_account')]
    public function recruteur(): Response
    {

        return $this->render('account/recruteur.html.twig');
    }


}
