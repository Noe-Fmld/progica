<?php

namespace App\Controller;

use App\Entity\Regions;
use App\Form\SearchType;
use App\Repository\GiteRepository;
use App\Repository\CitiesRepository;
use App\Repository\RegionsRepository;
use App\Repository\DepartmentsRepository;
use App\Repository\OptionPriceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search', methods: ['GET', 'POST'])]
    public function index(RegionsRepository $regionsRepository, DepartmentsRepository $departmentsRepository, CitiesRepository $citiesRepository, GiteRepository $giteRepository, OptionPriceRepository $optionPriceRepository, Request $request): Response
    {
        // $region = new Regions();
        // $form = $this->createForm(SearchType::class, $region);
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Recherche par ville
            $city_id = $form->get("ville")->getData();
            $city = $citiesRepository->find($city_id);
            $gites_in_city[] = $giteRepository->findByCity($city_id);
            

            // Recherche par département
            $departement_code = $city->getDepartmentCode()->getCode();
            $cities_in_department = $citiesRepository->findByDepartmentCode($departement_code);

            foreach ($cities_in_department as $city_in_department) {
                $city_dpt_id = $city_in_department->getId();
                if ($giteRepository->findByCity($city_dpt_id)) {
                    if ($giteRepository->findByCity($city_dpt_id) != $giteRepository->findByCity($city_id)) {
                        $gites_in_department[] = $giteRepository->findByCity($city_dpt_id);
                    }
                    
                }
            }


            // Recherche par région
            $region_code = $city->getDepartmentCode()->getRegionCode()->getCode();
            $departments_in_region = $departmentsRepository->findByRegionCode($region_code);
            $cities_in_region = $citiesRepository->findByDepartmentCode($departments_in_region);
            
            foreach ($cities_in_region as $city_in_region) {
                $city_rg_id = $city_in_region->getId();
                if ($giteRepository->findByCity($city_rg_id)) {
                    if ($giteRepository->findByCity($city_rg_id) != $giteRepository->findByCity($city_id)) {
                        $gites_in_region[] = $giteRepository->findByCity($city_rg_id);
                    }
                    
                }
                
            }

            // J'aimerais supprimer les gites_in_region s'ils existent dans gites_in_department
            // foreach ($gites_in_region as $index => $gite_in_region) {
                
            //     if ($gite_in_region === $gites_in_department) {
            //         dump("ok");
            //         // unset($gites_in_region[$index]);
            //     }
            // }


            dump($gites_in_city);
            
            dump($gites_in_department);

            dd($gites_in_region);
            
            
            return $this->redirectToRoute('app_gite_index', [], Response::HTTP_SEE_OTHER);
        }


        // return $this->render('search/index.html.twig', [
        //     'regions' => $regions,
        // ]);
        return $this->renderForm('search/index.html.twig', [
            'form' => $form,
        ]);
    }
}
// A passer : Localisation (région, dpt, ville) + nb couchage (gites) + options