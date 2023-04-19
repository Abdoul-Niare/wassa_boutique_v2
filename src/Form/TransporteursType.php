<?php

namespace App\Form;

use App\Entity\Transporteurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransporteursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameTransport', options:[
                'label'=>'Nom du Transporteur'
            ])
            ->add('description', options:[
                'label'=>'Description de la livraison'
            ])

            ->add('priceTransport', MoneyType::class, options:[
                'label'=>'Prix',
                'divisor'=>100,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transporteurs::class,
        ]);
    }
}
