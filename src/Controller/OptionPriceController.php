<?php

namespace App\Controller;

use App\Entity\OptionPrice;
use App\Form\OptionPriceType;
use App\Repository\GiteRepository;
use App\Repository\OptionPriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/option-price')]
class OptionPriceController extends AbstractController
{
    #[Route('/', name: 'app_option_price_index', methods: ['GET'])]
    public function index(OptionPriceRepository $optionPriceRepository, GiteRepository $giteRepository): Response
    {
        $gites = $giteRepository->findByOwner($this->getUser());
        $gites_array = [];
        foreach ($gites as $gite) {
            if ($gite->getId() == $_GET["id_gite"]) {
                $gites_array[] = $gite;
            }
        }
        return $this->render('option_price/index.html.twig', [
            'option_prices' => $optionPriceRepository->findByGite($gites_array),
        ]);
    }

    #[Route('/new', name: 'app_option_price_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OptionPriceRepository $optionPriceRepository): Response
    {
        $optionPrice = new OptionPrice();
        $form = $this->createForm(OptionPriceType::class, $optionPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // PROBLEME AVEC INSERTION
            $optionPrice->setGite($_GET["id_gite"]);

            $optionPriceRepository->add($optionPrice);
            return $this->redirectToRoute('app_option_price_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('option_price/new.html.twig', [
            'option_price' => $optionPrice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_option_price_show', methods: ['GET'])]
    public function show(OptionPrice $optionPrice): Response
    {
        return $this->render('option_price/show.html.twig', [
            'option_price' => $optionPrice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_option_price_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OptionPrice $optionPrice, OptionPriceRepository $optionPriceRepository): Response
    {
        $form = $this->createForm(OptionPriceType::class, $optionPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $optionPriceRepository->add($optionPrice);
            return $this->redirectToRoute('app_option_price_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('option_price/edit.html.twig', [
            'option_price' => $optionPrice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_option_price_delete', methods: ['POST'])]
    public function delete(Request $request, OptionPrice $optionPrice, OptionPriceRepository $optionPriceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$optionPrice->getId(), $request->request->get('_token'))) {
            $optionPriceRepository->remove($optionPrice);
        }

        return $this->redirectToRoute('app_option_price_index', [], Response::HTTP_SEE_OTHER);
    }
}
