<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request): Response
    {
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class,$candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $candidat->setCv('');


            $candidat->setUser($this->getUser());
            $this->entityManager->persist($candidat);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_candidat_account');
        }

        return $this->render('connexion/candidat.html.twig', [
            'form'=>$form->createView()
        ]);
    }

}
