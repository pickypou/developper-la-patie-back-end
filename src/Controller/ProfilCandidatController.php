<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
class ProfilCandidatController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/candidat/profil', name: 'app_profil_candidat')]
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class,$candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
                //recupération du fichier cv
                /*@var UploadedFile $fichierPdf*/
            $fichierPdf = $form->get('cv')->getData();
            
            //on verifie si le fichier a été envoyée et est valide
            if($fichierPdf){
                $nomFichierOriginal = pathinfo($fichierPdf->getUser(), PATHINFO_FILENAME);
                //reformater le nom de la photo pour avoir un nom sans caractères spécifiques pour être conforme à une url lorsqu'on va vouloir récupérer le fichier depuis le site
                   
                   // On utilise l'interface de slugger par injection dans l'action
                    $nomFichierReformate = $slugger->slug($nomFichierOriginal);
                    //créer un nom unique pour chaque fichers avec le nom formaté et unidentifiant unique généré par uniquid()
                    $nomFichier = $nomFichierReformate . '-' . uniqid() . '.' . $fichierPdf->getExtension();

                    
                   
                    //déplacer le fichier dans un repertoire spécifique sur le serveur
                    Try {
                        //La methode move prend en compte le dossier de destination et le nom du fichier(d'où l'unicité pour ne pas gérer l'existance du nom)
                        //mettre en paramètre le dossier de destination dans les config
                        $fichierPdf->move(
                            $this->getParameter('cv'),
                            $nomFichier
                        );
                    }catch (FileException $e) {
                        // pour gérer l'exception d'une éventuelle erreur lors de l'enregistrement du fichier
                        throw $e;
                    }

                    //enregistre uniquement le nom du fichier 
                    $candidat->setCv($nomFichier);


            };

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
