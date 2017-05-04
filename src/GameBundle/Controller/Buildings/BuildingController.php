<?php

namespace GameBundle\Controller\Buildings;

use DateTime;
use GameBundle\Entity\Building;
use GameBundle\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BuildingController extends Controller
{
    public function upgrade($name, Player $player)
    {
        $building = $player->getBuilding($name);
        $level = $building->getLevel();

        $upgradeTime = $building->getType()->GetUpgradeTime();
        $priceLimit = $building->getType()->GetPriceLimit();
        $buildingPrice = $building->getType()->GetPrice();
        $reqTime = $level * $upgradeTime;

        $timeleft = null;
        $timestamp = null;

        if ($building->getUpgraded()) {
            $timestamp = $building->getUpgraded()->getTimestamp();
        }

        if (!is_null($timestamp)) {
            $timeleft = (new DateTime('now'))->getTimestamp() - $timestamp;
            if ($timeleft > $reqTime) {
                $building->setUpgraded(null);

                $building->setLevel(++$level);
                $em = $this->getDoctrine()->getManager();
                $em->persist($player);
                $em->flush();
                $timeleft = null;
            }

        }
        $reqTime = $level * $upgradeTime;
        $price = $level * $buildingPrice;

        if ($price > $priceLimit) {
            $price = $priceLimit;
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
        return
            [
                'time' => $time,
                'timeleft' => $timeleft,
                'price' => $price
            ];
    }
    /**
     * @param $name
     * @param Player $player
     */
    public function upgradeAction($name, $player)
    {
        $apartment = $player->getBuilding('apartment');
        $building = $player->getBuilding($name);
        $buildingPrice = $building->getType()->GetPrice();
        $priceLimit = $building->getType()->GetPriceLimit();

        $building->setUpgraded(new DateTime('now'));

        $price = $buildingPrice * $building->getLevel();
        if ($price > $priceLimit) {
            $price = $priceLimit;
        }

        $apartment->setResource($apartment->getResource() - $price);

    }
}
