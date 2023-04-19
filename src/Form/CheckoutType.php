<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Transporteurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       $user = $options['user']; //On injecte les donneés de l'utilisateur.
       
        $builder
            ->add('address', EntityType::class, [
                'class'=> Address::class,
                'required'=> true,
                'choices' =>$user->getAddresses(),
                'multiple'=> false,
                'expanded'=> true
            ])
            ->add('transporteurs', EntityType::class, [
                'class'=> Transporteurs::class,
                'required'=> true,
                'multiple'=> false,
                'expanded'=> true
            ])// Options du champs, requis, choix multiple= non.
            
            ->add('informations', TextareaType::class, [
                'required'=> true,
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'user'=> array() // tableau de une ou plusieurs adresses.
            
        ]);
    }
}
