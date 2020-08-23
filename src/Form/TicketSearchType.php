<?php

namespace App\Form;

use App\Entity\Tickets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,["required"=>false,"label"=>false,"attr"=>["placeholder"=>"saisir un nom et/ou prénom"]])
            ->add('flashingdepot',ChoiceType::class, [
                "required" => "false",
                "label"=> false,
                'choices'  => [
                    'tous les tickets' => 'tous',
                    'tickets flashés' => 'yes',
                    'tickets non flashés' => 'no',
                ],
                "attr"=>["class"=>"dropdown"]
            ] )
            ->add('rechercher',SubmitType::class,["attr"=>["class"=>"mb10px"]])



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tickets::class,
        ]);
    }
}
