<?php

namespace GameBundle\Controller\Admins;

use GameBundle\Entity\Player;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    /**
     *
     * @Route("/map/{id}", name="players_map")
     * @Method("GET")
     */
    public function mapAction($id)
    {
        $current = null;
        if ($this->get("security.authorization_checker")->isGranted("ROLE_USER")) {
            $current = $this->getUser();
        }

        $player = $this->getDoctrine()->getRepository(Player::class)->findOneBy(
            [
                'id' => $id
            ]);


        return $this->render(':players:map.html.twig',
            [
                'player' => $player,
                'current' => $current
            ]);
    }
}
