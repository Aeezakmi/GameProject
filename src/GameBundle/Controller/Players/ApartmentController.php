<?php

namespace GameBundle\Controller\Players;

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
        return $this->render('players/apartment.html.twig');
    }
}
