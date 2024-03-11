<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Route('/api/{regionId}', name: 'app_api')]
    public function fetchGeoData($regionId): Response
    {

        $url = 'https://geo.api.gouv.fr/regions/'.$regionId.'/departements';

        $response = file_get_contents($url);
    
        // Decode the JSON response
        $datas = json_decode($response, true);
        
        return $this->render('api/index.html.twig', [
            'datas' => $datas,
        ]);
    }

    public function produitsByDepartement($departementId, UtilisateurRepository $utilisateurRepository, ProduitRepository $produitRepository)
    {
        // Récupérer le code postal du département à partir des données de l'API ou de toute autre source
        $cp = $this->getCodePostalFromAPI($departementId);
    
        // Récupérer le vendeur associé au code postal du département
        $vendeur = $utilisateurRepository->findOneBy(['cp' => $cp]);
    
        // Vérifier si le vendeur a été trouvé
        if (!$vendeur) {
            // Redirection vers une page d'erreur ou une page par défaut
            return new RedirectResponse($this->generateUrl('app_error'));
        }
    
        // Récupérer la liste des produits du vendeur
        $produits = $produitRepository->findBy(['vendeur' => $vendeur]);
    
        // Redirection vers la vue affichant la liste des produits
        return $this->render('produit/liste.html.twig', [
            'produits' => $produits,
        ]);
    }
}