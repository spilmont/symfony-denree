<?php

namespace App\Controller;

use App\Entity\Tickets;
use App\Entity\User;
use App\Form\TicketSearchType;
use App\Form\UserSearchType;
use Doctrine\ORM\Tools\Pagination\Paginator;
use mysql_xdevapi\Statement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request)
    {
        $searchForm = $this->createForm(UserSearchType::class);
        $searchForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();

        if($searchForm->isSubmitted() && $searchForm->isValid()){



            $lastname = $searchForm->getData()->getLastname();
            $firstname = $searchForm->getData()->getFirstname();

            $validState = $searchForm["valid"]->getData();


            if($validState == "tous")
                $users = $em->getRepository(User::class)->userSearch($lastname,$firstname);
            elseif ($validState == "validé")
                $users = $em->getRepository(User::class)->userSearchWithValid($lastname,$firstname, true);
            elseif ($validState == "en attente")
                $users = $em->getRepository(User::class)->userSearchWithValid($lastname,$firstname, false);







            if($users == null){
                $this->addFlash('erreur', 'Auccun utilisateur trouvé ');
            }
        }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController', "users" => $users,
            'searchForm'=> $searchForm->createView()
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
        //$user = $em->getRepository(User::class)->find($userId);

        $ticket = $em->getRepository(Tickets::class)->find($idTicket);


        if( $this->getUser()->getRoles()[0] == "ROLE_ADMIN"){

            $ticket->setFlashingDepot(1);
            $em->flush();

            return $this->redirectToRoute("admin");

        }
        return $this->redirectToRoute("home");
    }



    /**
     * @Route("admin/showArchivetickets", name="ShowArchiveTickets" )
     */
    public function showArchiveTickets(Request $request){

        $searchForm = $this->createForm(TicketSearchType::class);
        $searchForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $tickets = $em->getRepository(Tickets::class)->findBy(["archived"=>1]);

        if($searchForm->isSubmitted() && $searchForm->isValid()){



            $name = $searchForm->getData()->getName();
            $flashedState = $searchForm["flashingdepot"]->getData();




                if($flashedState == "tous")
                    $tickets = $em->getRepository(Tickets::class)->searchWithoutFlashingOption($name );
                elseif ($flashedState == "yes")
                    $tickets = $em->getRepository(Tickets::class)->searchWithFlashingOption($name, true );
                elseif ($flashedState == "no")
                    $tickets = $em->getRepository(Tickets::class)->searchWithFlashingOption($name, false );








            if($tickets == null){
                $this->addFlash('erreur', 'Auccun ticket trouvé ');
            }
        }




        return $this->render('admin/archiveTickets.html.twig',["tickets"=> $tickets,"searchForm"=>$searchForm->createView()]);
    }



}