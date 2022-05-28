<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilCandidatController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/candidat/profil', name: 'app_profil_candidat')]
    public function index(): Response
    {
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class, $candidat);
        if ($form->isSubmitted() && $form->isValid()){
            $candidat = $form->getData();
            $this->entityManager->persist($candidat);
            $this->entityManager->flush();

        }
        return $this->render('profil_candidat/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
