<?php

namespace App\Controller;

use App\Entity\Recruteur;
use App\Form\RecruteurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilRecruteurController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this ->entityManager = $entityManager;
    }
    #[Route('/recruteur/profil', name: 'app_profil_recruteur')]
    public function index(Request $request): Response
    {
        $recruteur = new Recruteur();
        $form = $this->createForm(RecruteurType::class, $recruteur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $recruteur->setUser($this->getUser());
            $this->entityManager->persist($recruteur);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_recruteur_account');
        }

        return $this->render('connexion/recruteur.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
