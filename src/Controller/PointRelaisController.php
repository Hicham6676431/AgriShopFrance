<?php

namespace App\Controller;

use App\Entity\PointRelais;
use App\Form\PointRelaisType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PointRelaisRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PointRelaisController extends AbstractController
{
    #[Route('/point_relais/new', name: 'new_point_relais')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $pointRelais = new PointRelais();
        
        $form = $this->createForm(PointRelaisType::class, $pointRelais);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $pointRelais = $form->getData();
                $entityManager->persist($pointRelais);
            
                $entityManager->flush();
            
                return $this->redirectToRoute('app_point_relais');
            }
            
            return $this->render('point_relais/new.html.twig' , [
                'formAddPointRelais' => $form,
            ]);
            
        }



    #[Route('/point/relais', name: 'app_point_relais')]
    public function index(PointRelaisRepository $pointRelaisRepository): Response
    {

        $pointsRelais = $pointRelaisRepository->findAll();

        return $this->render('point_relais/index.html.twig', [
            'pointsRelais' => $pointsRelais,
        ]);
    }
    
    #[Route('/points-relais/{departementId}', name: 'points_relais_par_region')]
    public function pointsRelaisParRegion(PointRelaisRepository $pointRelaisRepository, $departementId): Response
    {
        // Récupérer les points relais par région (département)
        $pointsRelais = $pointRelaisRepository->findPointsRelaisByDepartement($departementId);

        // Afficher les points relais dans votre vue
        return $this->render('point_relais/points_relais_par_region.html.twig', [
            'pointsRelais' => $pointsRelais,
            'departementId' => $departementId,
        ]);
    }


    
    #[Route('/point-relais/{id}', name: 'point_relais_show')]
    public function show(PointRelais $pointRelais): Response
    {
        return $this->render('point_relais/show.html.twig', [
            'pointRelais' => $pointRelais,
        ]);
    }

    #[Route('/point-relais/{id}/delete', name: 'delete_point_relais')]
    public function delete(PointRelais $pointRelais, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($pointRelais);
        $entityManager->flush();
        return $this->redirectToRoute('app_point_relais');
    }
}




