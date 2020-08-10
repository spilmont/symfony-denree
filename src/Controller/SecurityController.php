<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
       return $this->redirectToRoute('user',['id'=>$this->getUser()->getId()]);
       }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {

        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $register = new User();

        $register->setRoles(["ROLE_USER"]);
        $register->setValid(0);





        $form = $this->createForm(RegisterType::class, $register);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('register', 'compte créé, vous pouver maintenant vous conneté');


           $pasword = $passwordEncoder->encodePassword($register, $register->getPlainPassword());
           $register->setPassword($pasword);

             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($register);
             $entityManager->flush();

            return $this->redirectToRoute('home');
        }



        return $this->render('security/register.html.twig',['form'=>$form->createView()]);

    }


    /**
     * @Route("/update/{id}", name="app_udapte")
     */
    public function updateUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, $id){
        $entityManager = $this->getDoctrine()->getManager();
        $register =  $entityManager->getRepository(User::class)->find($id);





        $form = $this->createForm(RegisterType::class, $register)
        ->remove('nbfamilly')
        ->remove('lastname')
        ->remove('firstname')
        ->remove('email')

        ;



        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('update', 'compte modifié avec succes');


            $pasword = $passwordEncoder->encodePassword($register, $register->getPlainPassword());
            $register->setPassword($pasword);


            $entityManager->flush();

            return $this->redirectToRoute('user',['id'=>$register->getId()]);
        }



        return $this->render('security/update.html.twig',['form'=>$form->createView()]);

    }

    /**
     * @Route("/delete/{id}", name="app_delete")
     */
    public function delete($id){

        $entityManager = $this->getDoctrine()->getManager();
        $delete =  $entityManager->getRepository(User::class)->find($id);

        $entityManager->remove($delete);
        $entityManager->flush();

        return $this->redirectToRoute("admin");


    }

}
