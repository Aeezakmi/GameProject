<?php

namespace GameBundle\Controller\Players;

use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DiscotechController extends Controller
{
    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/discotech", name="player_discotech")
     * @Method("GET")
     */
    public function discotech()
    {
        $player = $this->getUser();
        return $this->render('players/discotech.html.twig',
            [
                'player' => $player
            ]);
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/discotech", name="player_discotech_action")
     * @Method("POST")
     */
    public function discotechAction()
    {
        $player = $this->getUser();

        $cnt = 0;
        if(isset($_POST['mutri'])){
            $cnt = intval($_POST['mutri']);
        }


        $player->getDiscotech()->addMutra($cnt);
        $player->pay($cnt* 20);

        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();

        return $this->redirectToRoute('player_discotech');
    }
}
