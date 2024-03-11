<?php

namespace App\Controller;

use App\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(Request $request, ApiController $api): Response
    {

        // $data = $api->getRegions($request);

        // if($data)[
        // var_dump($data)
        // ];
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
           
        ]);
    }

    #[Route('/test/home', name: 'app_test')]
    public function test(ApiController $api, Request $request): Response
    {

         // Appel de la méthode getRegions pour récupérer les données JSON
        $jsonData = $api->getRegions($request);
        // dd($jsonData);
        
        // Convertir les données JSON en tableau associatif
        $data = json_decode($jsonData->getContent(), true);
        
        // dd($data);
        // Passer les données à la vue Twig
        return $this->render('home/test.html.twig', [
            'data' => $data
        ]);
    }
}
