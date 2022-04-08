<?php

namespace App\Controller;

use App\Entity\Gite;
use App\Repository\GiteRepository;
use App\Repository\CitiesRepository;
use App\Repository\OptionPriceRepository;
use App\Repository\RegionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(GiteRepository $giteRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'gites' => $giteRepository->findBy([], ['id' => 'DESC']),
            
        ]);
    }
    
    #[Route('/rooms/{id}', name: 'app_show_one_gite')]
    public function showOneGite(Gite $gite, OptionPriceRepository $optionPriceRepository): Response
    {
        $options = $optionPriceRepository->findByGite($gite);
        return $this->render('default/onegite.html.twig', [
            'gite' => $gite,
            'options' => $options
        ]);
    }

    // Ajouter avec Houssem pour liste déroulante dynamique de Ville
    #[Route('/_cities', name: 'app_get_cities')]
    public function getCities(CitiesRepository $citiesRepository, Request $request): Response
    {
        
        $cities = $citiesRepository->findByName($request->query->get('q'));
        
        $cities_array = [];
        foreach ($cities as $city) {
            $cities_array[] = [
                'id' => $city->getId(),
                'text' => $city->getName().' - '.$city->getZipCode()
            ];
        }
        
        return $this->json([
            "results" => $cities_array
        ]);
    }
    #[Route('/_regions', name: 'app_get_regions')]
    public function getRegions(RegionsRepository $regionsRepository, Request $request): Response
    {
        
        
        $regions = $regionsRepository->findByName($request->query->get('q'));
        $regions_array = [];
        foreach ($regions as $region) {
            $regions_array[] = [
                'id' => $region->getId(),
                'text' => $region->getName()
            ];
        }
        
        return $this->json([
            "results" => $regions_array
        ]);
    }
    
}
