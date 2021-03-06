<?php

namespace App\Controller;


use App\Entity\Tickets;
use App\Entity\User;
use App\Form\DocumentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="user")
     */
    public function index(Request $request, $id )
    {
        $ticket= new Tickets();

        $document = new User() ;
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('doucuments')->getData();


            $fileName = $this->generateUniqueFileName().".".$file->guessExtension();

            $file->move(
                $this->getParameter('documents_directory')."/".$id,
                $fileName
            );

            $document->setDoucuments($fileName);
        }





       $em = $this->getDoctrine()->getManager();
        $tickets = $em->getRepository(Tickets::class)->countTickets($id);

        $showTickets = $em->getRepository(Tickets::class)->showTickets($id);

        $date = $this->ladate();



        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $dateChoice =( isset($_POST['choice'])? filter_var($_POST['choice'],FILTER_SANITIZE_STRING):$_POST='');

        $iExists =  $em->getRepository(Tickets::class)->findOneBy(["user"=> $id, "depotdate" => $dateChoice]);


        if($dateChoice !=='' and $tickets < 2 and !isset($iExists)  ){



            $ticket->setName($user->getLastname().' '.$user->getFirstname());
            $ticket->setCountry($user->getAddress());
            $ticket->setNbfamilly($user->getNbfamilly());
            $ticket->setDate(date('d/m/y'));
            $ticket->setDepotdate($dateChoice);
            $ticket->setFlashingdepot(0);
            $ticket->setUser($user);
            $ticket->setSemaine(date('W'));
            $ticket->setArchived(0);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute("user",["id"=>$id]);
        }


        $this->archivetickets();





        return $this->render('user/tickets.html.twig', [
            'controller_name' => 'UserController', 'user' => $user,'tickets'=>$tickets,
            'showTickets'=>$showTickets,'date'=>$date,'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/user/ajax/{id}", name="user_ajax")
     */
    public function ajaxticket($id)
    {

        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);




        $datas=[
            "lastname"=>$user->getlastname(),
            "firstname"=>$user->getFirstname(),
            "familly"=>$user->getNbfamilly(),
            "adress"=>$user->getAddress(),
            "date"=> date('d/m/y'),


        ];


        return $this->json($datas, 200);
    }


  
    private function archivetickets(){

        $em = $this->getDoctrine()->getManager();
        $tickets = $em->getRepository(Tickets::class)->findAll();


        foreach ($tickets as $ticket ){

            if( +date('W')> $ticket->getSemaine()+1 and $ticket->getArchived() == 0)  {

                $ticket->setArchived(1);

                $em->flush();
        }
        }
    }


    /**
     * @Route("/user/check/{id}", name="user_check")
     */
    public function checkTicket($id){

        $tickets = $this->getDoctrine()->getManager()->getRepository(Tickets::class)->findBy(["user"=>$id,"archived" => 0]);
        $countTicket = count($tickets);



        foreach ($tickets as $ticket){
            $depotdate= $ticket->getDepotdate();

        }



        $data = ['countTicket'=>$countTicket,'depodate'=> $depotdate];


        return $this->json($data, 200);
    }


    private function ladate(){
        $semaine = date('W')+1;
        $annee = date('Y');

        function get_lundi_vendredi_from_week($week,$year,$format="d/m/Y") {

            $firstDayInYear=date("N",mktime(0,0,0,1,1,$year));

            if ($firstDayInYear<5)
                $shift=-($firstDayInYear-1)*86400;
            else
                $shift=(8-$firstDayInYear)*86400;

            if ($week>1) $weekInSeconds=($week-1)*604800; else $weekInSeconds=0;


            $lundi=mktime(0,0,0,1,1,$year)+$weekInSeconds+$shift;
            $mercredi=mktime(0,0,0,1,3,$year)+$weekInSeconds+$shift;
            $Vendredi=mktime(0,0,0,1,5,$year)+$weekInSeconds+$shift;

            return ["Lundi " . date($format,$lundi),"Mercredi " . date($format,$mercredi),"Vendredi " . date($format,$Vendredi)];

        }

        $joursDepot = get_lundi_vendredi_from_week($semaine, $annee);

        return[$joursDepot[0],$joursDepot[1],$joursDepot[2]];





    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("user/{userId}/ticket/{idTicket}", name="myTicket")
     */
    public function myTicket($userId, $idTicket){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($userId);


        $ticket = $em->getRepository(Tickets::class)->find($idTicket);



        $url =    $_SERVER['HTTP_HOST']."/admin/".$user->getId()."/ticket/".$ticket->getId()."/validate" ;

        return $this->render("user/myTickets.html.twig",["ticket" => $ticket,"user"=> $user,"url"=> $url]);

    }


    /**
     * @Route("user/{idUser}/watchmytickets", name="watch_tickets")
     */
    public function watckMyTickets($idUser){
        $em = $this->getDoctrine()->getManager();
        $user =$em->getRepository(User::class)->find($idUser);

        $tickets = $em->getRepository(Tickets::class)->findBy(["user" => $idUser,"archived"=>0]);

        return $this->render("user/watchMyTickets.html.twig",["user"=> $user, "tickets" =>$tickets]);

    }






}