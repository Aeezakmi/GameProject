<?php

namespace GameBundle\Controller\Players;

use GameBundle\Entity\Player;
use GameBundle\Form\PlayerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlayersController extends Controller
{
    /**
     * @Route("/register", name="player_register_form")
     * @Method("GET")
     */
    public function registerPlayerForm()
    {
        $form = $this->createForm(PlayerType::class);

        return $this->render(':players:register.html.twig',
            [
                'playerForm' => $form->createView()
            ]
            );
    }

    /**
     * @Route("/register", name="player_register_action")
     * @Method("POST")
     */
    public function registerPlayerAction(Request $request){
        $player = new Player();

        $form = $this->createForm(
            PlayerType::class,
            $player);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){

            $password = $this->get('security.password_encoder')
                ->encodePassword($player, $player->getPassword());
            $player->setPassword($password);

            $em= $this->getDoctrine()
                ->getManager();
            $em->persist($player);
            $em->flush();

            $this->addFlash('success', "You registered successfully.");

            return $this->redirectToRoute('player_login_form');
        }

        $this->redirectToRoute('player_register_form');

    }


    /**
     * @Route("/login", name="player_login_form")
     */
    public function loginPlayerAction()
    {
        return $this->render(':players:login.html.twig');
    }
}
