<?php

namespace GameBundle\Controller\Players;

use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use function Symfony\Component\VarDumper\Tests\Caster\reflectionParameterFixture;

class ApartmentController extends Controller
{
    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/apartment", name="player_apartment")
     * @Method("GET")
     */
    public function apartmentAction()
    {
        $player = $this->getUser();
        $player->getApartment()->setUpdated(New DateTime('now'));
        $level = $player->getApartment()->getLevel();

        $upCost = $level * 5;
        if($level > 20){
            $upCost = 100;
        }

        $reqTime = $level * 30;
        $timeleft = null;
        $timestamp = null;

        if ($player->getApartment()->getUpgrade()) {
            $timestamp = $player->getApartment()->getUpgrade()->getTimestamp();
        }

        if (!is_null($timestamp)) {
            $timeleft = (new DateTime('now'))->getTimestamp() - $timestamp;
            if ($timeleft > $reqTime) {
                $player->getApartment()->setUpgrade(null);

                $player->getApartment()->setLevel(++$level);
                $em = $this->getDoctrine()->getManager();
                $em->persist($player);
                $em->flush();
                $timeleft = null;
            }

        }
        $price = $level * 60;
        if ($price > 900) {
            $price = 900;
        }


        $time = new DateTime();

        if (!is_null($timeleft) && $timeleft > 1) {
            $time->setTime(0, 0, 0)->modify('+' . $reqTime - $timeleft . ' second');
        } else {
            $time->setTime(0, 0, 0)->modify('+' . $reqTime . ' second');
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();

        return $this->render('players/apartment.html.twig',
            [
                'player' => $player,
                'price' => $price,
                'upcost' => $upCost,
                'time' => $time,
                'timestamp' => $timeleft
            ]);
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/apartment", name="player_apartment_upgrade")
     * @Method("POST")
     */
    public function upgradeApartment()
    {

        $player = $this->getUser();
        $level = $player->getApartment()->getLevel();
        $updated = $player->getApartment()->getUpdated()->getTimestamp();

        if (isset($_POST['upgrade'])) {
            $player->getApartment()->setUpgrade(new DateTime('now'));
            $price = $level * 60;
            if ($price > 900) {
                $price = 900;
            }
            $player->getApartment()->setKinti($player->getApartment()->getKinti() - $price);
        }
        else if (isset($_POST['income'])){
            $seconds = time() - $updated;
            $minutes = $seconds / 60;
            $cnt = floor($minutes / 2);

            $player->getApartment()->addKinti($cnt * 20);
            $player->getApartment()->setUpdated(new Datetime('now'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();

        return $this->redirect('/apartment');
    }
}
