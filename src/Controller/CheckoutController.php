<?php

namespace App\Controller;


use App\Form\CheckoutType;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    private $panierService;
    protected $requestStack;

    public function __construct(PanierService $panierService, RequestStack $requestStack)
    {
        $this->panierService = $panierService;
        $this->requestStack = $requestStack;
    }

    #[Route('/checkout', name: 'app_checkout')]
    public function index(Request $request,  RequestStack $requestStack): Response
    {
        
        // on appelle l'utilisateur connecté.
        $user = $this->getUser();
        // on recupere le Panier.
        $panier= $this->panierService->getFullCart();
        // on recupere le total du panier.
        $total =$this->panierService->getTotal();
         
        // si je n'ai pas de produit dans le panier, on retourne à l'accueil.
        if (!isset ($panier)) {
            return $this->redirectToRoute('main');
        }

        // Si je n'ai pas d'adresse de livraison 
        if (!$user->getAddresses()->getValues()) {
            $this->addFlash('checkout_message', "Merci de renseigner une adresse avant de continuer !");
            return $this->redirectToRoute('app_address_new');
        }

        // Gestion du formulaire 
        $form = $this->createForm(CheckoutType::class, null, ['user'=>$user]);

        return $this->render('checkout/index.html.twig', [
            'controller_name' => 'CheckoutController',
            'panier'=> $panier,
            'total'=>$total,
            'user'=>$user,
            'checkout'=> $form->createView(),
        ]);


    }
}
