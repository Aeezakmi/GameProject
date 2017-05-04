<?php

namespace GameBundle\Controller\Buildings;

use DateTime;
use GameBundle\Controller\Buildings\BuildingController;
use GameBundle\Entity\Player;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DiscotechController extends BuildingController
{
    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/discotech", name="player_discotech")
     * @Method("GET")
     */
    public function discotechAction()
    {
        /** @var Player $player */
        $player = $this->getUser();
        $building = $player->getBuilding('discotech');

        $resourcePrice = $building->getType()->GetResourcePrice();
        $resourceLimit = $building->getType()->GetResourceLimit();

        $upgrade = $this->upgrade('discotech',$player);
        $level = $building->getLevel();

        $mutraCost = $resourcePrice - $level;
        if($level > 20){
            $mutraCost = $resourceLimit;
        }

        return $this->render('players/discotech.html.twig',
            [
                'player' => $player,
                'price' => $upgrade['price'],
                'mutraCost' => $mutraCost,
                'time' => $upgrade['time'],
                'timeleft' => $upgrade['timeleft']
            ]);
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/discotech", name="player_discotech_upgrade")
     * @Method("POST")
     */
    public function upgradeDiscotech()
    {
        /** @var Player $player */
        $player = $this->getUser();

        if (isset($_POST['upgrade'])) {
            $this->upgradeAction('discotech', $player);
        }
        else if (isset($_POST['buy_mutri'])){
            $discotech = $player->getBuilding('discotech');
            $apartment = $player->getBuilding('apartment');
            $price = $discotech->getType()->GetResourcePrice();
            $limit = $discotech->getType()->GetResourceLimit();
            $level = $discotech->getLevel();
            $cnt = intval($_POST['buy_mutri']);


            $price = $price - $level;
            if($level > 20){
                $price = $limit;
            }

            if (!($cnt * $price > $apartment->getResource())){
                $discotech->setResource($discotech->getResource() + $cnt);
                $apartment->setResource($apartment->getResource() - $cnt * $price);
            }
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();

        return $this->redirect('/discotech');
    }
}
