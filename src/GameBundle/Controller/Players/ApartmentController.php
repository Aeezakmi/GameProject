<?php

namespace GameBundle\Controller\Players;

use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApartmentController extends Controller
{
    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/apartment", name="player_apartment")
     */
    public function apartmentAction()
    {
        date_default_timezone_set('Europe/Sofia');
        $player = $this->getUser();
        $updated = $player->getApartment()->getUpdated()->getTimestamp();

        $seconds = time() - $updated;
        $minutes = $seconds / 60;
        $cnt = floor($minutes / 2);

        $player->getApartment()->addKinti($cnt * 10);
        $player->getApartment()->setUpdated(new Datetime('now'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();

        return $this->render('players/apartment.html.twig',
            [
                'player' => $player
            ]);
    }
}
