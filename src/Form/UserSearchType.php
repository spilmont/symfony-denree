<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('lastname',null,["label"=> false,"required"=> false,"attr"=>["placeholder"=>"saisir un nom"]])
            ->add('firstname',null,["label"=> false,"required"=> false,"attr"=>["placeholder"=>"saisir un prénom"]])
            ->add('valid',ChoiceType::class,[
                "label"=>false,
                "choices"=>[
                    "tous les utilisateurs" => "tous",
                    "utilisateurs validés" => "validé",
                    "utilisteurs en attente" => "en attente"
                ],
                "attr"=>["class"=>"dropdown"]
            ])
            ->add("rechercher", SubmitType::class, ["attr"=>["class" => "mb10px"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
