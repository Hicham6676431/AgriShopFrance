<?php



namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier/ajouter/{id}', name: 'panier_ajouter')]
    public function ajouter($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);

        // Rediriger l'utilisateur vers la page du panier ou ailleurs
        return $this->redirectToRoute('panier_afficher');
    }

    #[Route('/panier', name: 'panier_afficher')]
    public function afficher(SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        // Convertir les ID de produits en entités Produit pour afficher des informations détaillées
        // Cela nécessitera une requête au repository de Produit pour récupérer les objets Produit
        
        return $this->render('panier/afficher.html.twig', [
            'panier' => $panier,
            // 'produits' => $produits, si vous convertissez les ID en entités Produit
        ]);
    }

    // Ajoutez des méthodes pour supprimer et modifier les quantités des produits dans le panier
}
