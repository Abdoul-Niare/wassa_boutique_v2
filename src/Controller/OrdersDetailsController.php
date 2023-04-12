<?php

namespace App\Controller;

use App\Entity\OrdersDetails;
use App\Form\OrdersDetailsType;
use App\Repository\OrdersDetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orders/details')]
class OrdersDetailsController extends AbstractController
{
    #[Route('/', name: 'app_orders_details_index', methods: ['GET'])]
    public function index(OrdersDetailsRepository $ordersDetailsRepository): Response
    {
        return $this->render('orders_details/index.html.twig', [
            'orders_details' => $ordersDetailsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_orders_details_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrdersDetailsRepository $ordersDetailsRepository): Response
    {
        $ordersDetail = new OrdersDetails();
        $form = $this->createForm(OrdersDetailsType::class, $ordersDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordersDetailsRepository->save($ordersDetail, true);

            return $this->redirectToRoute('app_orders_details_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orders_details/new.html.twig', [
            'orders_detail' => $ordersDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{orders}', name: 'app_orders_details_show', methods: ['GET'])]
    public function show(OrdersDetails $ordersDetail): Response
    {
        return $this->render('orders_details/show.html.twig', [
            'orders_detail' => $ordersDetail,
        ]);
    }

    #[Route('/{orders}/edit', name: 'app_orders_details_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OrdersDetails $ordersDetail, OrdersDetailsRepository $ordersDetailsRepository): Response
    {
        $form = $this->createForm(OrdersDetailsType::class, $ordersDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordersDetailsRepository->save($ordersDetail, true);

            return $this->redirectToRoute('app_orders_details_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orders_details/edit.html.twig', [
            'orders_detail' => $ordersDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{orders}', name: 'app_orders_details_delete', methods: ['POST'])]
    public function delete(Request $request, OrdersDetails $ordersDetail, OrdersDetailsRepository $ordersDetailsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ordersDetail->getOrders(), $request->request->get('_token'))) {
            $ordersDetailsRepository->remove($ordersDetail, true);
        }

        return $this->redirectToRoute('app_orders_details_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
