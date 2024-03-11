<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{   
    
    #[Route('/categorie/new', name: 'new_categorie')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $categorie = new Categorie();
        
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
                $categorie = $form->getData();
                $entityManager->persist($categorie);
            
                $entityManager->flush();
            
                return $this->redirectToRoute('app_categorie');
            }
            
            return $this->render('categorie/new.html.twig' , [
                'formAddCategorie' => $form,
            ]);
            
        }




   
    #[Route('/categorie/{departementId}', name: 'app_categorie')]
    public function index(CategorieRepository $categorieRepository, $departementId, ProduitRepository $produitRepository): Response
    {

        $categories = $categorieRepository->findAll();
        $nombreProduitsParCategorie = [];

        foreach ($categories as $categorie) {
            $nombreProduitsParCategorie[$categorie->getId()] = $produitRepository->countProduitsByCategorie($categorie, $departementId);
        }

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'departementId' => $departementId,
            'nombreProduitsParCategorie' => $nombreProduitsParCategorie

        ]);
    }
    

    #[Route('/categorie/{id}', name: 'show_categorie')]
    public function show(Categorie $categorie): Response
    {
      

        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie
        ]);
    }

    #[Route('/categorie/{id}/delete', name: 'delete_categorie')]
    public function delete(Categorie $categorie, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->redirectToRoute('app_categorie');
    }

    


    

}
