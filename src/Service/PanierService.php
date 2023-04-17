<?php

namespace App\Service;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class PanierService
{

    protected $requestStack;
    protected $productsRepository;
    private $tva = 0.2;

    public function __construct(RequestStack $requestStack, ProductsRepository $productsRepository)
    {
        $this->requestStack = $requestStack;
        $this->productsRepository = $productsRepository;
    }

    public function add($id)
    {
        // On récupère le panier actuel
        $panier = $this->requestStack->getSession()->get("panier", []);
        

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $this->requestStack->getSession()->set("panier", $panier);
    }

    public function remove($id)
    {
         // On récupère le panier actuel
         $panier = $this->requestStack->getSession()->get("panier", []);
         
 
         if(!empty($panier[$id])){
             if($panier[$id] > 1){
                 $panier[$id]--;
             }else{
                 unset($panier[$id]);
             }
         }
 
         // On sauvegarde dans la session
         $this->requestStack->getSession()->set("panier", $panier);

    }


    public function delete($id)
    {
        // On récupère le panier actuel
        $panier = $this->requestStack->getSession()->get("panier", []);
      

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        // On sauvegarde dans la session
        $this->requestStack->getSession()->set("panier", $panier);
    }


    // fonction creer un objet fullcart qui contient tous les elements indispensables.
    public function getFullCart(): array
    {
        $panier = $this->requestStack->getSession()->get("panier", []);

        // On "fabrique" les données
        $fullCart = [];

        foreach ($panier as $id => $quantite) {
            $product = $this->productsRepository->find($id);
            $fullCart[] = [
                "produit" => $product,
                "quantite" => $quantite,
            ];
        }
        return $fullCart;
    }

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getFullCart() as $item) {
            $total += $item['produit']->getPrice() / 100 * $item['quantite'];
        }
        return $total;
    }
}
