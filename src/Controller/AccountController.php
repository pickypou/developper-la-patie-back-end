<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/candidat/compte', name: 'app_candidat_account')]
    public function candidat(): Response
    {
        return $this->render('account/index.html.twig');
    }

    #[Route('/recruteur/compte', name: 'app_recruteur_account')]
    public function recruteur(): Response
    {
        return $this->render('account/recruteur.html.twig');
    }


}
