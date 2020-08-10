<?php

namespace App\Controller;

use App\Entity\Tickets;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class HistoryController extends AbstractController
{
    public function ticketTOHistory(){

        $em = $this->getDoctrine()->getManager();
        $ticket = $em->getRepository(Tickets::class)->findAll() ;

        return $this->json($ticket);

    }


}
