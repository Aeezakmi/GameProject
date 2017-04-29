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
        $level = $player->getDiscotech()->getLevel();

        $cost = $level * 50;
        $timeleft = null;
        $timestamp = null;

        if ($player->getDiscotech()->getUpgrade()) {
            $timestamp = $player->getDiscotech()->getUpgrade()->getTimestamp();
        }

        if (!is_null($timestamp)) {
            $timeleft = (new DateTime('now'))->getTimestamp() - $timestamp;
            if ($timeleft > $cost) {
                $player->getDiscotech()->setUpgrade(null);

                $player->getDiscotech()->setLevel(++$level);
                $em = $this->getDoctrine()->getManager();
                $em->persist($player);
                $em->flush();
                $timeleft = null;
            }

        }

        $mutraCost = 30 - $level;

        $price = $level * 60;
        if ($price > 900) {
            $price = 900;
        }

        $time = new DateTime();

        if (!is_null($timeleft) && $timeleft > 1) {
            $time->setTime(0, 0, 0)->modify('+' . $cost - $timeleft . ' second');
        } else {
            $time->setTime(0, 0, 0)->modify('+' . $cost . ' second');
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();

        return $this->render('players/discotech.html.twig',
            [
                'player' => $player,
                'price' => $price,
                'time' => $time,
                'timestamp' => $timeleft,
                'mutraCost' => $mutraCost
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
        $level = $player->getDiscotech()->getLevel();
        $mutraCost = 30 - $level;
        $price = $level * 60;

        if (isset($_POST['buy_mutri'])) {
            $mutri = intval($_POST['buy_mutri']);

            if ($player->getApartment()->getKinti() >= $mutri * $mutraCost) {

                $player->getDiscotech()->addMutra($mutri);
                $player->getApartment()->setKinti($player->getApartment()->getKinti() - $mutraCost);
            }
        }
         else if (isset($_POST['upgrade'])) {
            $player->getDiscotech()->setUpgrade(new DateTime('now'));

            if ($price > 900) {
                $price = 900;
            }

            $player->getApartment()->setKinti($player->getApartment()->getKinti() - $price);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();

        return $this->redirect('/discotech');
    }
}
