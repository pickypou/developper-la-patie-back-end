<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnonceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/annonce', name: 'app_annonce')]
    public function index(Request $request): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
           $annonce->setRecruteur($this->getRecruteur());

            $this->entityManager->persist($annonce);
            $this->entityManager->flush();
        }
        return $this->render('annonce/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
