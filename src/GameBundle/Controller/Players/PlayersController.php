<?php

namespace GameBundle\Controller\Players;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlayersController extends Controller
{
    /**
     * @Route("/register", name="player_register")
     */
    public function registerPlayerAction()
    {
        return $this->render(':players:register.html.twig');
    }


    /**
     * @Route("/login", name="player_login")
     */
    public function loginPlayerAction()
    {
        return $this->render(':players:login.html.twig');
    }
}
