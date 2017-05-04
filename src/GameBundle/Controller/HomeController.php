<?php

namespace GameBundle\Controller;


use DateTime;
use GameBundle\Entity\Player;
use GameBundle\Entity\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $players = $this->getDoctrine()->getRepository(Player::class)->findAll();
        $player = null;



        if ($this->get("security.authorization_checker")->isGranted("ROLE_USER")) {
            $player = $this->getUser();
        }
        return $this->render('users/index.html.twig',
            [
                'players' => $players,
                'user' => $player
            ]);
    }
}
