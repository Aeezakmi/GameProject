<?php

namespace GameBundle\Controller\Players;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DiscotechController extends Controller
{
    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/discotech", name="player_discotech")
     */
    public function apartmentAction()
    {
        return $this->render('players/discotech.html.twig');
    }
}
