<?php

namespace App\Controller;

use App\Form\ProduitType;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController
{

    #[Route('/utilisateur/new', name: 'new_utilisateur')]
    public function new(Request $request): Response
    {
        $utilisateur = new Utilisateur();
        
        $form = $this->createForm(ProduitType::class, $utilisateur);
        // $form->handleRequest($request);
        
        // if($form->isSubmitted() && $form->isValid()){
            
            //     $utilisateur = $form->getData();
            
            
            //     $entityManager->persist($utilisateur);
            
            //     $entityManager->flush();
            
            //     return $this->redirectToRoute('app_utilisateur');
            // }
            
            return $this->render('utilisateur/new.html.twig' , [
                'formAddUtilisateur' => $form,
            ]);
            
        }



    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateurs = $utilisateurRepository->findBy([], ["pseudo" => "ASC"]);
      
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs
        ]);
    }

    #[Route('/utilisateur/{id}', name: 'show_utilisateur')]
    public function show(Utilisateur $utilisateur): Response
    {
      

        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur
        ]);
    }

    #[Route('/utilisateur/{id}/delete', name: 'delete_utilisateur')]
    public function delete(Utilisateur $utilisateur, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($utilisateur);
        $entityManager->flush();
        return $this->redirectToRoute('app_utilisateur');
    }

    
}
