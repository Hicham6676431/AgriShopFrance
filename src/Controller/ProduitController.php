<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Form\ProduitType;
use App\Service\FileUploader;
use App\Service\ImageService;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    #[Route('/produit/new/{id}', name: 'new_produit')]
    public function new($id, Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager ): Response
    {   
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);

        $user = $this->getUser();
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
 
        if($form->isSubmitted() && $form->isValid()){

            $produit = $form->getData();

            $imageFiles = $form->get('images')->getData();

            // dd($imageFiles);
            foreach($imageFiles as $imageFile)
            {
                $imageFileName = $fileUploader->upload($imageFile);
                
                $image = new Image();

                $produit->addImage($image);
                $image->setNom($imageFileName);    
                
            }
            
            $produit->setCategories($categorie);
            $produit->setVendeur($user);

            $entityManager->persist($produit, $image);
            
            $entityManager->flush();
            
            return $this->redirectToRoute('app_produit');
        }

        
            
        return $this->render('produit/new.html.twig' , [
                'formAddProduit' => $form->createView(),

  
        ]);
            
    }



    #[Route('/produit', name: 'app_produit')]
    public function index(ProduitRepository $produitRepository): Response
    {

        $produits = $produitRepository->findBy([], ["nom" => "ASC"]);

        return $this->render('produit/index.html.twig', [
            'produits' => $produits
           
        ]);
    }

    #[Route('/produit/{id}', name: 'show_produit')]
    public function show($id, Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit
        ]);
    }

    #[Route('/produit/{id}/delete', name: 'delete_produit')]
    public function delete(Produit $produit, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($produit);
        $entityManager->flush();
        return $this->redirectToRoute('app_produit');
    }
    
    
    
    private $produitRepository;
    
    public function __construct(ProduitRepository $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }



    #[Route('/{categorieId}/produits/{departementId}', name: 'produitsParRegion')]
    public function produitsParRegion(ProduitRepository $produitRepository, $categorieId, $departementId): Response
    {
        // Utiliser le repository pour obtenir les produits par région
        $produits = $produitRepository->findProduitsByVendeurRegion($departementId, $categorieId);
   
        // Afficher les produits dans votre vue
        return $this->render('produit/produitsParRegion.html.twig', [
          
            'produits' => $produits,
            'departementId' => $departementId,
           

        ]);
    }

    
    
}  








