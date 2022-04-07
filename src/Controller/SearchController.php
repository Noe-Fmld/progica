<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\GiteRepository;
use App\Repository\CitiesRepository;
use App\Repository\OptionPriceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search', methods: ['GET', 'POST'])]
    public function index(CitiesRepository $citiesRepository, GiteRepository $giteRepository, OptionPriceRepository $optionPriceRepository, Request $request): Response
    {

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Recherche par ville
            $city_id = $form->get("ville")->getData();
            $city = $citiesRepository->find($city_id);
            $gites_in_city = $giteRepository->findByCity($city_id);
            

            // Recherche par département
            $departement_code = $city->getDepartmentCode()->getCode();
            $gites_in_department = $giteRepository->findByDpt($departement_code, ["id" => $city_id]);
            

            // Recherche par région

            $region_code = $city->getDepartmentCode()->getRegionCode()->getCode();
            $gites_in_region = $giteRepository->findByReg($region_code, ["id" => $departement_code]);
        

            return $this->render('search/result.html.twig', [
                "gites_city" => $gites_in_city,
                "gites_department" => $gites_in_department,
                "gites_region" => $gites_in_region,
            ]);
        }


       
        return $this->renderForm('search/index.html.twig', [
            'form' => $form,
        ]);
    }
}
// A passer : Localisation (région, dpt, ville) + nb couchage (gites) + options