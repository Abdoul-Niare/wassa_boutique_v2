// Fonction lire un panier
    // public function getPanier(){
    //     return $this->getPanier('panier',[]);
    // }


    // public function getDataPanier(Products $product, ProductsRepository $productsRepository){
    //     $panier=$this->getPanier();
    //     $dataPanier= [];
    //     $quantitePanier=0;
    //     $subTotal=0;

    //     foreach($panier as $id => $quantite){
    //         $product = $productsRepository->find($id);
    //         if($product){ 
    //         $dataPanier['products'][] = [
    //             "produit" => $product,
    //             "quantite" => $quantite,
    //         ];
    //         $quantitePanier +=$quantite;
    //         $subTotal += $product->getPrice() * $quantite;
    //      } else{
    //         $this->deleteAll($id);
    //      }
            
    //     }
    //     $dataPanier['data']=[
    //         'quantitePanier'=>$quantitePanier,
    //         'subTotal'=> $subTotal,
    //         'taxe'=> round($subTotal*$this->tva,2),
    //         'subTotalTTC'=> round(($subTotal + ($subTotal*$this->tva)),2)
    //     ];
    //     return $dataPanier;


    // }
