<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesFormType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/categories', name: 'admin_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $categories = $categoriesRepository->findBy([], ['categoryOrder' => 'asc']);

        return $this->render('admin/categories/index.html.twig', compact('categories'));
    }

    #[Route('/ajout', name: 'add')]
    public function ajoutCategorie(Request $request, CategoriesRepository $categoriesRepository, SluggerInterface $slugger): Response
    {
        $categorie = new Categories;
        $counter = 1;
        $form =$this->createForm(CategoriesFormType::class, $categorie);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

           // On gere l'ordre des Categories
            $order =$counter++;
            $categorie->setCategoryOrder($order);

             // On génère le slug
             $slug = $slugger->slug($categorie->getName());
             $categorie->setSlug($slug);

           $categoriesRepository->save($categorie, true);
           $this->addFlash('success', 'Categorie ajouté avec succès');

           // On redirige
           return $this->redirectToRoute('admin_categories_index');
       }

       return $this->render('admin/categories/add.html.twig',[
               'form' => $form->createView()
           ]);

            
    }


    // #[Route('/ajout', name: 'add', methods: ['GET', 'POST'])]
    // public function ajoutCategorie(Request $request, Categories $categories, CategoriesRepository $categoriesRepository): Response
    // {
    //     $categorie = new Categories;
    //     $form =$this->createForm(CategoriesFormType::class, $categorie);
    //     $form -> handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    
            
    //         // On gere l'ordre des Categories
    //         $order = $this->Id++;
    //         $categorie->setCategoryOrder($order);
          
    //         $categoriesRepository->save($categorie, true);

            
    //        $this->addFlash('success', 'Categorie ajouté avec succès');

    //        // On redirige
    //        return $this->redirectToRoute('admin_categories_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('marque/new.html.twig', [
    //         'categorie' => $categorie,
    //         'form' => $form,
    //     ]);
    // }

}