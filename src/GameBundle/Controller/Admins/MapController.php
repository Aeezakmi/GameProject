<?php

namespace GameBundle\Controller\Admins;

use GameBundle\Entity\Player;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    /**
     * @Route("/map/{id}", name="players_map")
     * @Method("GET")
     */
    public function mapAction($id)
    {
        /** @var Player $player */
        /** @var Player $current */
        $current = null;
        $travelTime = 0;

        $player = $this->getDoctrine()->getRepository(Player::class)->findOneBy(
            [
                'id' => $id
            ]);

        if ($this->get("security.authorization_checker")->isGranted("ROLE_USER")) {
            $current = $this->getUser();
            $distance = sqrt(pow($player->getPosX()-$current->getPosX(),2) + pow($player->getPosY()-$current->getPosY(),2));
            $travelTime = floor($distance * 60);
        }



        return $this->render(':players:map.html.twig',
            [
                'player' => $player,
                'current' => $current,
                'travelTime' => $travelTime
            ]);
    }
}
