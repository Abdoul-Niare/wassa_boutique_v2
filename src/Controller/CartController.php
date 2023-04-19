<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/cart', name:'cart_')]
class CartController extends AbstractController
{

    private $tva=0.2;
   protected $panierService;

    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService;
    }

    #[Route('/', name:'index')]
    public function index(PanierService $panierService)
    {
        $fullCart = $panierService->getFullCart();
        $total = $panierService->getTotal();
        $quantitePanier=0;
       

        return $this->render('cart/index.html.twig', compact("fullCart", "total", "quantitePanier"));
    }

    #[Route('/add/{id}', name:'add')]
    public function add($id, PanierService $panierService)
    {
        $panierService->add($id);

        $this->addFlash('success', 'Produit ajouté dans votre panier');
        return $this->redirectToRoute("cart_index");
    }

     
    #[Route('/remove/{id}', name:'remove')]
    public function remove($id, PanierService $panierService)
    {
       $panierService->remove($id);

        return $this->redirectToRoute("cart_index");
    }


    #[Route('/delete/{id}', name:'delete')]
    public function delete($id, PanierService $panierService)
    {
        $panierService->delete($id);
        return $this->redirectToRoute("cart_index");
    }

    #[Route('/delete', name:'delete_all')]
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("cart_index");
    }
    
}
