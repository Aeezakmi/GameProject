<?php

namespace GameBundle\Controller\Buildings;

use DateTime;
use GameBundle\Controller\Buildings\BuildingController;
use GameBundle\Entity\Player;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use function Symfony\Component\VarDumper\Tests\Caster\reflectionParameterFixture;

class ApartmentController extends BuildingController
{
    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/apartment", name="player_apartment")
     * @Method("GET")
     */
    public function apartmentAction()
    {
        /** @var Player $player */
        $player = $this->getUser();
        $building = $player->getBuilding('apartment');
        $player->getBuilding('apartment')->setUpdated(new DateTime('now'));

        $resourcePrice = $building->getType()->GetResourcePrice();
        $resourceLimit = $building->getType()->GetResourceLimit();

        $upgrade = $this->upgrade('apartment',$player);
        $level = $building->getLevel();

        $income = $level * $resourcePrice;
        if($level > 20){
            $income = $resourceLimit;
        }


        return $this->render('players/apartment.html.twig',
            [
                'player' => $player,
                'price' => $upgrade['price'],
                'income' => $income,
                'time' => $upgrade['time'],
                'timeleft' => $upgrade['timeleft']
            ]);
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/apartment", name="player_apartment_upgrade")
     * @Method("POST")
     */
    public function upgradeApartment()
    {
        /** @var Player $player */
        $player = $this->getUser();
        $updated = $player->getBuilding('apartment')->getUpdated()->getTimestamp();
        $price = $player->getBuilding('apartment')->getType()->getResourcePrice();

        if (isset($_POST['upgrade'])) {
            $this->upgradeAction('apartment', $player);
        }
        else if (isset($_POST['income'])){
            $seconds = time() - $updated;
            $minutes = $seconds / 60;
            $cnt = floor($minutes / 2);

            $player->getBuilding('apartment')->setResource($player->getBuilding('apartment')->getResource() + $cnt * $price);
            $player->getBuilding('apartment')->setUpdated(new Datetime('now'));
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();

        return $this->redirect('/apartment');
    }
}
