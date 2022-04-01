<?php

namespace App\Controller;

use App\Entity\Gite;
use App\Form\GiteType;
use App\Repository\CitiesRepository;
use App\Repository\GiteRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/gite')]
class GiteController extends AbstractController
{
    #[Route('/', name: 'app_gite_index', methods: ['GET'])]
    public function index(GiteRepository $giteRepository, ContactRepository $contactRepository): Response
    {
        return $this->render('gite/index.html.twig', [
            'gites' => $giteRepository->findByOwner($this->getUser()),
            'contacts' => $contactRepository->findByGiteOwner($this->getUser())
        ]);
    }
    

    #[Route('/new', name: 'app_gite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GiteRepository $giteRepository, CitiesRepository $citiesRepository): Response
    {
        
        $gite = new Gite();
        $form = $this->createForm(GiteType::class, $gite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $city_id = $form->get("ville")->getData();
            $city = $citiesRepository->find($city_id);
            $gite->setCity($city);
            $gite->setOwner($this->getUser());
            if (!$gite->getIsAnimalAccepted()) {
                $gite->setPrixAnimal(null);   
            }
            $giteRepository->add($gite);
            return $this->redirectToRoute('app_gite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gite/new.html.twig', [
            'gite' => $gite,
            'form' => $form,
        ]);

    }

    #[Route('/{id}', name: 'app_gite_show', methods: ['GET'])]
    public function show(Gite $gite): Response
    {
        return $this->render('gite/show.html.twig', [
            'gite' => $gite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gite $gite, GiteRepository $giteRepository): Response
    {
        $form = $this->createForm(GiteType::class, $gite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $giteRepository->add($gite);
            return $this->redirectToRoute('app_gite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gite/edit.html.twig', [
            'gite' => $gite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gite_delete', methods: ['POST'])]
    public function delete(Request $request, Gite $gite, GiteRepository $giteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gite->getId(), $request->request->get('_token'))) {
            $giteRepository->remove($gite);
        }

        return $this->redirectToRoute('app_gite_index', [], Response::HTTP_SEE_OTHER);
    }
}
