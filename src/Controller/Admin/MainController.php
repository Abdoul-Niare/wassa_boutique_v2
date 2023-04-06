<?php

namespace App\Controller\Admin;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class MainController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        // return $this->render('admin/index.html.twig');
        return $this->render('admin/index.html.twig', [
            'categories' => $categoriesRepository->findBy([], ['categoryOrder' => 'asc'])
        ]);
    }
}