<?php

namespace App\Controller;

use App\Entity\Transporteurs;
use App\Form\TransporteursType;
use App\Repository\TransporteursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transporteurs')]
class TransporteursController extends AbstractController
{
    #[Route('/', name: 'app_transporteurs_index', methods: ['GET'])]
    public function index(TransporteursRepository $transporteursRepository): Response
    {
        return $this->render('transporteurs/index.html.twig', [
            'transporteurs' => $transporteursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_transporteurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TransporteursRepository $transporteursRepository): Response
    {
        $transporteur = new Transporteurs();
        $form = $this->createForm(TransporteursType::class, $transporteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transporteursRepository->save($transporteur, true);

            return $this->redirectToRoute('app_transporteurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transporteurs/new.html.twig', [
            'transporteur' => $transporteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transporteurs_show', methods: ['GET'])]
    public function show(Transporteurs $transporteur): Response
    {
        return $this->render('transporteurs/show.html.twig', [
            'transporteur' => $transporteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transporteurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transporteurs $transporteur, TransporteursRepository $transporteursRepository): Response
    {
        $form = $this->createForm(TransporteursType::class, $transporteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transporteursRepository->save($transporteur, true);

            return $this->redirectToRoute('app_transporteurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transporteurs/edit.html.twig', [
            'transporteur' => $transporteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transporteurs_delete', methods: ['POST'])]
    public function delete(Request $request, Transporteurs $transporteur, TransporteursRepository $transporteursRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transporteur->getId(), $request->request->get('_token'))) {
            $transporteursRepository->remove($transporteur, true);
        }

        return $this->redirectToRoute('app_transporteurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
