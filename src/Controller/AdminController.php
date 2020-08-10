<?php

namespace App\Controller;

use App\Entity\Tickets;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController', "users" => $users,
        ]);
    }

    /**
     * @Route("admin/documents/{id}", name="admin-document")
     */
    public function document($id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
          $realpathimages = glob($this->getParameter('documents_directory').'/'.$id.'/*' );


          $images = null;

          foreach ($realpathimages as $image ){
              $images[] =  basename($image);
          }





            return $this->render('admin/document.html.twig', ['user' => $user, 'images'=>$images]);
        }

    /**
     * @Route("admin/user/yes/{id}", name="yes-user")
     */
    public function yesUser($id){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        $user->setValid(true);

        $em->flush();

        return $this->redirectToRoute('admin',['user'=>$user]);

    }

    /**
     * @Route("admin/{userId}/ticket/{idTicket}/validate", name="validateTicket")
     */
    public function validateTicket( $userId, $idTicket)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($userId);

        $ticket = $em->getRepository(Tickets::class)->find($idTicket);


        if( $this->getUser()->getRoles()[0] == "ROLE_ADMIN"){

            $ticket->setFlashingDepot(1);
            $em->flush();

            return $this->redirectToRoute("admin");

        }
        return $this->redirectToRoute("home");
    }



}