<?php

namespace GameBundle\Controller;


use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        if ($this->get("security.authorization_checker")->isGranted("ROLE_USER")) {

            date_default_timezone_set('Europe/Sofia');
            $player = $this->getUser();
            $player->getApartment()->setUpdated(New DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();

        }
        return $this->render('base.html.twig');
    }
}
