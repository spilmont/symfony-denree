<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,['label'=> 'adresse email'])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'mot de passe'),
                'second_options' => array('label' => 'repeter le mot de passe'),
            ))
            ->add('lastname', TextType::class, ['label'=> 'nom'])
            ->add('firstname', TextType::class,['label'=> 'prénom'])
            ->add('nbfamilly', IntegerType::class,['label'=>'nombre de personnes du foyer'])
            ->add('address', TextType::class,['label'=> 'adresse postale'])
            ->add('envoyer', SubmitType::class)



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
